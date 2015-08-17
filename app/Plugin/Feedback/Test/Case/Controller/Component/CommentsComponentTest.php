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

App::uses('CommentsComponent', 'Feedback.Controller/Component');
App::uses('ComponentCollection', 'Controller');

/**
 * CommentsComponent Test Case
 *
 * @property CommentsComponent $Comments
 * @property PHPUnit_Framework_MockObject_MockObject $Controller
 * @property PHPUnit_Framework_MockObject_MockObject $Collection
 */
class CommentsComponentTest extends CakeTestCase
{
	private $_cookieInfo = array
		(
			'author_name' => 'Al Bundy',
			'author_email' => 'al@king.com',
			'author_website' => 'www.shoes.com',
			'remember_info' => true,
		);

	public function setUp()
	{
		parent::setUp();

		$this->Controller = $this->getMock('Controller');
		$this->Collection = $this->getMock
			(
				'ComponentCollection',
				array('getController')
			);
		$this->Controller->request = $this->getMock
			(
				'CakeRequest'
			);

		$this->Collection->expects($this->any())
			->method('getController')
			->will($this->returnValue($this->Controller));
	}

	public function tearDown()
	{
		unset($this->Comments);

		parent::tearDown();
	}

	private function setupMockCookieComponent(CommentsComponent &$Component)
	{
		$Component->Cookie = $this->getMock
			(
				'CookieComponent',
				array('read', 'write', 'delete')
			);
	}

	public function testBeforeRenderWithWrongAction()
	{
		$options = array('on' => array('view', 'index'));
		$this->Comments = new CommentsComponent($this->Collection, $options);

		$this->Controller->request->params['action'] = 'edit';
		$this->Controller->helpers = array();

		$this->Comments->beforeRender($this->Controller);

		$this->assertFalse(in_array('Feedback.Comments', $this->Controller->helpers));
	}

	public function testBeforeRenderWithValidAction()
	{
		$options = array('on' => array('view', 'index'));
		$this->Comments = new CommentsComponent($this->Collection, $options);
		$this->setupMockCookieComponent($this->Comments);

		$this->Controller->request->params['action'] = 'index';
		$this->Controller->helpers = array();

		$this->Comments->Cookie->expects($this->once())
			->method('read')
			->will($this->returnValue($this->_cookieInfo));

		$this->Comments->beforeRender($this->Controller);

		$this->assertTrue(in_array('Feedback.Comments', $this->Controller->helpers));
		$this->assertEquals($this->_cookieInfo, $this->Controller->request->data['Comment']);
	}

	public function testSaveInfo()
	{
		$this->Comments = new CommentsComponent($this->Collection);
		$this->setupMockCookieComponent($this->Comments);

		$info = array
			(
				'Stuff' => array
				(
					'doesnt_matter' => 'at_all',
					'shouldnt_be' => 'in_the_cookie',
				),
				'Comment' => $this->_cookieInfo
			);

		$this->Controller->request->data = $info;

		$this->Comments->Cookie->expects($this->once())
			->method('write')
			->with('Feedback.CommentInfo', $this->_cookieInfo, false, '+1 year');

		$this->Comments->saveInfo();
	}

	public function testForgetInfo()
	{
		$this->Comments = new CommentsComponent($this->Collection);
		$this->setupMockCookieComponent($this->Comments);

		$this->Comments->Cookie->expects($this->once())
			->method('delete')
			->with('Feedback.CommentInfo');

		$this->Comments->forgetInfo();
	}
}
