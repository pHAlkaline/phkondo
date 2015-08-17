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

App::uses('View', 'View');
App::uses('RatingsHelper', 'Feedback.View/Helper');

/**
 * RatingsHelper Test Case
 *
 * @property RatingsHelper $Ratings
 * @property View $View
 */
class RatingsHelperTest extends CakeTestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->View = new View();

		$this->View->request = $this->getMock('CakeRequest', array('_readInput'));
		$this->View->request->addParams
			(
				array
				(
					'models' => array('Article' => array()),
					'controller' => 'articles',
					'action' => 'view',
				)
			);

		$this->View->Session = $this->getMock('SessionHelper', array('read'));

		$this->Ratings = new RatingsHelper($this->View);
		$this->Ratings->Session = $this->View->Session;
	}

	public function tearDown()
	{
		unset($this->View);
		unset($this->Ratings);

		parent::tearDown();
	}

	public function testBeforeRender()
	{
		$this->Ratings->Session->expects($this->any())
			->method('read')
			->with('Feedback.RatingModels')
			->will($this->returnValue(array('Article' => 'Article')));

		$this->Ratings->beforeRender('add');

		$script_block = $this->View->fetch('script');
		$css_block = $this->View->fetch('css');

		$expected = array
			(
				'tag' => 'link',
				array
				(
					'attributes' => array
					(
						'rel' => 'stylesheet',
						'type' => 'text/css',
					)
				)
			);

		$this->assertTag($expected, $css_block);
		$this->assertRegExp('#/feedback/js/rateit-1.0.4/rateit.css#', $css_block);
		$this->assertRegExp('#/feedback/js/rateit-1.0.4/bigstars.css#', $css_block);

		$expected = array
			(
				'tag' => 'script',
				array
				(
					'attributes' => array
					(
						'type' => 'text/javascript',
					)
				)
			);

		$this->assertTag($expected, $script_block);
		$this->assertRegExp('#/feedback/js/rateit-1.0.4/jquery.rateit.min.js#', $script_block);
	}

	public function testDisplayFor()
	{
		$View = new View();
		$View->Session = $this->getMock('SessionHelper', array('read'));

		$View->request = $this->getMock('CakeRequest', array('_readInput'));
		$View->request->addParams
			(
				array
				(
					'models' => array('Article' => array()),
					'controller' => 'articles',
					'action' => 'view',
				)
			);

		$Ratings = $this->getMock('RatingsHelper', array('getRandomId'), array($View));
		$Ratings->Session = $View->Session;
		$Ratings->setModels(array('Article' => 'Content.Article'));

		$Ratings->expects($this->once())
			->method('getRandomId')
			->will($this->returnValue(666));

		$data = array
			(
				'Article' => array
				(
					'id' => 1,
				),
				'RatingSummary' => array
				(
					'total_rating' => 3.5,
					'total_votes' => 42,
				),
			);

		$result_html = $Ratings->display_for($data);
		$result_script = $View->fetch('script_execute');

		$expected = array
			(
				'tag' => 'div',
				'attributes' => array('class' => 'rating'),
				'child' => array
				(
					'tag' => 'div',
					'id' => 'rating-666',
					'attributes' => array('class' => 'rateit bigstars'),
				),
				'children' => array
				(
					'count' => 2,
				),
			);

		$this->assertTag($expected, $result_html);

		$expected = array
			(
				'tag' => 'span',
				'id' => 'message-666',
				'attributes' => array('class' => 'rating-message'),
			);

		$this->assertTag($expected, $result_html);

		$expected = array
			(
				'tag' => 'span',
				'id' => 'values-666',
				'attributes' => array('class' => 'rating-values'),
				'child' => array
				(
					'tag' => 'span',
					'content' => '3.50',
					'attributes' => array('class' => 'rating'),
				),
				'children' => array
				(
					'count' => 2,
					'only' => array('tag' => 'span'),
				),
			);

		$this->assertTag($expected, $result_html);

		$expected = array
			(
				'tag' => 'span',
				'content' => '42',
				'attributes' => array('class' => 'votes'),
			);

		$this->assertTag($expected, $result_html);

		$this->assertRegExp('/\$\(\'#rating-666\'\).rateit\({/', $result_script);
		$this->assertRegExp('/readonly: false/', $result_script);
		$this->assertRegExp('/\$\(\'#rating-666\'\).rateit\(\'value\', 3.5\);/', $result_script);
		$this->assertRegExp('#url: \'/feedback/ratings/add/Content.Article/1\'#', $result_script);
		$this->assertRegExp('/foreign_model: \'Article\',/', $result_script);
	}
}
