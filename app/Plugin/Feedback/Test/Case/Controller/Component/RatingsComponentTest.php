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
App::uses('RatingsComponent', 'Feedback.Controller/Component');
App::uses('ComponentCollection', 'Controller');

/**
 * RatingsComponent Test Case
 *
 * @property RatingsComponent $Ratings
 * @property PHPUnit_Framework_MockObject_MockObject $Controller
 * @property PHPUnit_Framework_MockObject_MockObject $Collection
 */
class RatingsComponentTest extends CakeTestCase
{
	private $_cookieData = array
		(
			'1' => '2.5',
			'2' => '3',
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

		$this->Controller->name = 'Tests';
		$this->Controller->modelClass = 'Test';

		$this->Collection->expects($this->any())
			->method('getController')
			->will($this->returnValue($this->Controller));

		$this->Ratings = new RatingsComponent($this->Collection);

		$this->Ratings->Cookie = $this->getMock
			(
				'CookieComponent',
				array('read', 'write', 'delete')
			);

		$this->Ratings->Session = $this->getMock
			(
				'SessionComponent',
				array('write'),
				array($this->Collection)
			);

		$this->Ratings->initialize($this->Controller);
	}

	public function tearDown()
	{
		unset($this->Ratings);

		parent::tearDown();
	}

	public function testBeforeRenderWithWrongAction()
	{
		$this->Controller->request->params['action'] = 'edit';
		$this->Controller->helpers = array();

		$this->Ratings->beforeRender($this->Controller);

		$this->assertFalse(in_array('Feedback.Ratings', $this->Controller->helpers));
	}

	public function testBeforeRenderWithValidAction()
	{
		$this->Controller->request->params['action'] = 'index';
		$this->Controller->helpers = array();

		$this->Ratings->Session->expects($this->at(0))
			->method('write')
			->with('Feedback.RatingModels', array('Test' => 'Test'));

		$this->Ratings->Session->expects($this->at(1))
			->method('write')
			->with('Feedback.TestRatings', $this->_cookieData);

		$this->Ratings->Cookie->expects($this->once())
			->method('read')
			->with('Feedback.TestRatings')
			->will($this->returnValue($this->_cookieData));

		$this->Ratings->beforeRender($this->Controller);

		$this->assertTrue(in_array('Feedback.Ratings', $this->Controller->helpers));
	}

	public function testWriteRatingCookie()
	{
		$this->Ratings->Cookie->expects($this->once())
			->method('write')
			->with('Feedback.TestRatings', $this->_cookieData, false, '+5 years');

		$this->Ratings->writeRatingCookie('Test', $this->_cookieData);
	}

	public function testReadRatingCookie()
	{
		$this->Ratings->Cookie->expects($this->once())
			->method('read')
			->with('Feedback.TestRatings')
			->will($this->returnValue($this->_cookieData));

		$this->assertEquals($this->_cookieData, $this->Ratings->readRatingCookie('Test'));
	}
}
