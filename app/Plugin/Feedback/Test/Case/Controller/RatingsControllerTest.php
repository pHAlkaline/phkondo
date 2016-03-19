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

App::uses('RatingsController', 'Feedback.Controller');
App::uses('RatingsComponent', 'Feedback.Controller/Component');

if (!class_exists('Article'))
{
	class Article extends CakeTestModel
	{
		public $name = 'Article';
	}
}

/**
 * RatingsController Test Case
 *
 */
class RatingsControllerTest extends ControllerTestCase
{
	private $cookieData =  array
		(
			'1' => '2.5',
		);

	public $fixtures = array
		(
			'plugin.feedback.article',
			'plugin.feedback.rating',
		);

	public function setUp()
	{
		parent::setUp();

		$this->generate
			(
				'Feedback.Ratings',
				array
				(
					'models' => array
					(
						'Feedback.Rating' => array('create', 'save'),
						'Article' => array('hasAny', 'read'),
					),
					'components' => array
					(
						'Feedback.Ratings' => array('writeRatingCookie', 'readRatingCookie'),
					),
				)
			);

		$this->Article = ClassRegistry::init('Article');

		// this doesn't work due to cake mocking me...
//		$this->controller->request->expects($this->any())
//			->method('clientIp')
//			->will($this->returnValue('127.0.0.1'));
//
//		$this->controller->request->expects($this->any())
//			->method('is')
//			->with('ajax')
//			->will($this->returnValue(true));

		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
	}

	public function tearDown()
	{
		unset($this->Article);
		unset($this->controller);

		parent::tearDown();
	}

	public function testAddInvalidCall1()
	{
		$result = $this->testAction('/feedback/ratings/add/Test', array('return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddInvalidCall2()
	{
		$result = $this->testAction('/feedback/ratings/add/Test/1', array('return' => 'headers', 'method' => 'get'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddMissingModel()
	{
		$result = $this->testAction('/feedback/ratings/add/Arse/1', array('return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddIncorrectRow()
	{
		$this->Article->expects($this->once())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(false));

		$result = $this->testAction('/feedback/ratings/add/Article/1', array('return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddRatingCookieExists()
	{
		$this->Article->expects($this->atLeastOnce())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$this->controller->Ratings->expects($this->once())
			->method('readRatingCookie')
			->with('Article')
			->will($this->returnValue($this->cookieData));

		$expected = array
			(
				'success' => false,
				'message' => __('You cannot vote more than once!'),
				'data' => array(),
			);

		$data = array();
		$result = $this->testAction('/feedback/ratings/add/Article/1', array('data' => $data, 'return' => 'contents', 'method' => 'post'));
		$result = json_decode($result, true);
		$this->assertEquals($expected, $result);
	}

	public function testAddMismatchedParams1()
	{
		$this->Article->expects($this->atLeastOnce())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$this->controller->Ratings->expects($this->once())
			->method('readRatingCookie')
			->with('Article')
			->will($this->returnValue(false));

		$data = array('Rating');
		$result = $this->testAction('/feedback/ratings/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddMismatchedParams2()
	{
		$this->Article->expects($this->atLeastOnce())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$this->controller->Ratings->expects($this->once())
			->method('readRatingCookie')
			->with('Article')
			->will($this->returnValue(false));

		$data = array('Rating' => array('foreign_model'));
		$result = $this->testAction('/feedback/ratings/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddMismatchedParams3()
	{
		$this->Article->expects($this->atLeastOnce())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$this->controller->Ratings->expects($this->once())
			->method('readRatingCookie')
			->with('Article')
			->will($this->returnValue(false));

		$data = array('Rating' => array('foreign_model', 'foreign_id'));
		$result = $this->testAction('/feedback/ratings/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddMismatchedParams4()
	{
		$this->Article->expects($this->atLeastOnce())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$this->controller->Ratings->expects($this->once())
			->method('readRatingCookie')
			->with('Article')
			->will($this->returnValue(false));

		$data = array('Rating' => array('foreign_model' => 'Article', 'foreign_id'));
		$result = $this->testAction('/feedback/ratings/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddMismatchedParams5()
	{
		$this->Article->expects($this->atLeastOnce())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$this->controller->Ratings->expects($this->once())
			->method('readRatingCookie')
			->with('Article')
			->will($this->returnValue(false));

		$data = array('Rating' => array('foreign_model' => 'Article', 'foreign_id' => 2));
		$result = $this->testAction('/feedback/ratings/add/Article/1', array('data' => $data, 'return' => 'headers', 'method' => 'post'));
		$this->assertArrayHasKey('Location', $result);
	}

	public function testAddBuildIncompleteData()
	{
		$this->Article->expects($this->atLeastOnce())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$this->controller->Ratings->expects($this->once())
			->method('readRatingCookie')
			->with('Article')
			->will($this->returnValue(false));

		$this->controller->Rating->expects($this->once())
			->method('save')
			->with(array(
				'Rating' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'author_ip' => '127.0.0.1',
				)
			))
			->will($this->returnValue(false));

		$data = array
			(
				'Rating' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
				)
			);

		$expected = array
			(
				'success' => false,
				'message' => __('There was an error while saving your vote'),
				'data' => array(),
			);

		$result = $this->testAction('/feedback/ratings/add/Article/1', array('data' => $data, 'return' => 'contents', 'method' => 'post'));
		$result = json_decode($result, true);
		$this->assertEquals($expected, $result);
	}

	public function testAddBuildAndSaveCorrectData()
	{
		$this->Article->expects($this->atLeastOnce())
			->method('hasAny')
			->with(array('id' => '1'))
			->will($this->returnValue(true));

		$this->controller->Ratings->expects($this->once())
			->method('readRatingCookie')
			->with('Article')
			->will($this->returnValue(false));

		$this->controller->Rating->expects($this->once())
			->method('save')
			->with(array(
				'Rating' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'author_ip' => '127.0.0.1',
					'rating' => '2.5',
				)
			))
			->will($this->returnValue(true));

		$this->controller->Ratings->expects($this->once())
			->method('writeRatingCookie')
			->with('Article', array('1' => '2.5'));

		$this->Article->expects($this->once())
			->method('read')
			->with(null, 1)
			->will($this->returnValue(array(
				'RatingSummary' => array('dummy' => 'data')
			)));

		$data = array
			(
				'Rating' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'rating' => '2.5',
				)
			);

		$expected = array
			(
				'success' => true,
				'message' => __('Thanks for voting!'),
				'data' => array('dummy' => 'data'),
			);

		$result = $this->testAction('/feedback/ratings/add/Article/1', array('data' => $data, 'return' => 'contents', 'method' => 'post'));
		$result = json_decode($result, true);
		$this->assertEquals($expected, $result);
	}
}
