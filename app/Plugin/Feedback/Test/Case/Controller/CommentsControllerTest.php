<?php
/**
	CakePHP Feedback Plugin

	Copyright (C) 2012-3827 dr. Hannibal Lecter / lecterror
	<http://lecterror.com/>

	Multi-licensed under:
		MPL <http://www.mozilla.org/MPL/MPL-1.1.html>
		LGPL <http://www.gnu.org/licenses/lgpl.html>
		GPL <http://www.gnu.org/licenses/gpl.html>
*/

App::uses('SessionComponent', 'Controller/Component');
App::uses('CommentsController', 'Feedback.Controller');

if (!class_exists('Article'))
{
	class Article extends CakeTestModel
	{
		public $name = 'Article';
	}
}

/**
 * CommentsController Test Case
 *
 */
class CommentsControllerTestCase extends ControllerTestCase
{
	public $fixtures = array
		(
			'plugin.feedback.article',
			'plugin.feedback.comment',
		);

	public function setUp()
	{
		parent::setUp();

		$this->generate
			(
				'Feedback.Comments',
				array
				(
					'models' => array
					(
						'Feedback.Comment' => array('create', 'save'),
						'Article' => array('hasAny'),
					),
					'components' => array
					(
						'Session',
						'Feedback.Comments',
					),
				)
			);

		$this->Article = ClassRegistry::init('Article');

		// this doesn't work due to cake mocking me...
//		$this->controller->request->expects($this->any())
//			->method('clientIp')
//			->will($this->returnValue('127.0.0.1'));

		$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
	}

	public function tearDown()
	{
		unset($this->controller);

		parent::tearDown();
	}

	public function testAddInvalidCall()
	{
		$result = $this->testAction('/feedback/comments/add/Test', array('return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);

		$result = $this->testAction('/feedback/comments/add/Test/1', array('return' => 'headers', 'method' => 'get'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddMissingModel()
	{
		$this->expectException('MissingTableException');
		$result = $this->testAction('/feedback/comments/add/Arse/1', array('return' => 'headers', 'method' => 'post'));
	}

	public function testAddIncorrectRow()
	{
		$this->Article->expects($this->once())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(false));

		$result = $this->testAction('/feedback/comments/add/Article/1', array('return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddMismatchedParams()
	{
		$this->Article->expects($this->atLeastOnce())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$data = array();
		$result = $this->testAction('/feedback/comments/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);

		$data = array('Comment');
		$result = $this->testAction('/feedback/comments/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);

		$data = array('Comment' => array('foreign_model'));
		$result = $this->testAction('/feedback/comments/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);

		$data = array('Comment' => array('foreign_model', 'foreign_id'));
		$result = $this->testAction('/feedback/comments/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);

		$data = array('Comment' => array('foreign_model' => 'Article', 'foreign_id'));
		$result = $this->testAction('/feedback/comments/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);

		$data = array('Comment' => array('foreign_model' => 'Article', 'foreign_id' => 2));
		$result = $this->testAction('/feedback/comments/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddBuildIncompleteData()
	{
		$this->Article->expects($this->once())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$data = array
			(
				'Comment' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'author_email' => 'arse@feck.com',
				)
			);

		$this->controller->Comment->expects($this->once())
			->method('save')
			->with(array(
				'Comment' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'user_id' => null,
					'author_ip' => '127.0.0.1',
					'author_email' => 'arse@feck.com',
				)
			))
			->will($this->returnValue(false));

		$result = $this->testAction('/feedback/comments/add/Article/1', array('data' => $data, 'return' => 'vars', 'method' => 'post'));
		$this->assertArrayHasKey('validation_errors', $result);
	}

	public function testAddBuildAndSaveCorrectData()
	{
		$this->Article->expects($this->once())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$this->controller->Comment->expects($this->once())
			->method('save')
			->with(array(
				'Comment' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'user_id' => null,
					'author_ip' => '127.0.0.1',
					'remember_info' => '1',
				)
			))
			->will($this->returnValue(true));

		$data = array
			(
				'Comment' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'remember_info' => '1',
				)
			);

		$this->controller->Comment->id = 5;
				
		$result = $this->testAction('/feedback/comments/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
		$this->assertContains('#comment-5', $result['Location']);
	}

	public function testAddCallSaveInfo()
	{
		$this->Article->expects($this->once())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$this->controller->Comment->expects($this->once())
			->method('save')
			->with(array(
				'Comment' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'user_id' => null,
					'author_ip' => '127.0.0.1',
					'author_name' => 'Father Dougal McGuire',
					'author_email' => 'arse@feck.com',
					'author_website' => 'http://www.doogle.com',
					'remember_info' => '1',
				)
			))
			->will($this->returnValue(true));

		$data = array
			(
				'Comment' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'author_name' => 'Father Dougal McGuire',
					'author_email' => 'arse@feck.com',
					'author_website' => 'http://www.doogle.com',
					'remember_info' => '1',
				)
			);

		$this->controller->Comment->id = 5;
		$this->controller->Comments->expects($this->once())->method('saveInfo');
				
		$result = $this->testAction('/feedback/comments/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
		$this->assertContains('#comment-5', $result['Location']);
	}

	public function testAddCallForgetInfo()
	{
		$this->Article->expects($this->once())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$this->controller->Comment->expects($this->once())
			->method('save')
			->with(array(
				'Comment' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'user_id' => null,
					'author_ip' => '127.0.0.1',
					'author_name' => 'Father Dougal McGuire',
					'author_email' => 'arse@feck.com',
					'author_website' => 'http://www.doogle.com',
					'remember_info' => '0',
				)
			))
			->will($this->returnValue(true));

		$data = array
			(
				'Comment' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'author_name' => 'Father Dougal McGuire',
					'author_email' => 'arse@feck.com',
					'author_website' => 'http://www.doogle.com',
					'remember_info' => '0',
				)
			);

		$this->controller->Comment->id = 5;
		$this->controller->Comments->expects($this->once())->method('forgetInfo');
				
		$result = $this->testAction('/feedback/comments/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
		$this->assertContains('#comment-5', $result['Location']);
	}
}
