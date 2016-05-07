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

App::uses('RatedBehavior', 'Feedback.Model/Behavior');

/**
 * RatedBehavior Test Case
 *
 * @property Model $Article
 */
class RatedBehaviorTest extends CakeTestCase
{
	public $fixtures = array
		(
			'plugin.feedback.article',
			'plugin.feedback.rating',
		);

	public function setUp()
	{
		parent::setUp();

		$this->Article = ClassRegistry::init('Article');
	}

	public function tearDown()
	{
		unset($this->Article);

		parent::tearDown();
	}

	public function testAssociations()
	{
		$this->assertArrayNotHasKey('Rating', $this->Article->hasMany);

		$this->Article->Behaviors->load('Feedback.Rated');
		$this->assertArrayHasKey('Rating', $this->Article->hasMany);

		$expected = array
			(
				'className'		=> 'Feedback.Rating',
				'conditions'	=> 'Rating.foreign_model = \'Article\'',
				'foreignKey'	=> 'foreign_id',
			);

		foreach ($expected as $key => $value)
		{
			$this->assertArrayHasKey($key, $this->Article->hasMany['Rating']);
			$this->assertEquals($expected[$key], $this->Article->hasMany['Rating'][$key]);
		}

		$this->Article->Behaviors->unload('Rated');
		$this->assertArrayNotHasKey('Rating', $this->Article->hasMany);
	}

	public function testAfterFindAverages()
	{
		$this->Article->Behaviors->load('Feedback.Rated');

		$expected = array
			(
				'total_votes' => 2,
				'total_rating' => 2.5
			);

		$result = $this->Article->find('first', array('conditions' => array('id' => 1)));

		$this->assertArrayHasKey('RatingSummary', $result);
		$this->assertEquals($expected, $result['RatingSummary']);
	}

	public function testAfterFindNoAverages()
	{
		$this->Article->Behaviors->load('Feedback.Rated');

		$expected = array();
		$result = $this->Article->find('first', array('conditions' => array('id' => 2)));

		$this->assertArrayNotHasKey('RatingSummary', $result);
	}
}
