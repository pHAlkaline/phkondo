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

App::uses('CommentableBehavior', 'Feedback.Model/Behavior');

/**
 * CommentableBehavior Test Case
 *
 * @property Model $Article
 */
class CommentableBehaviorTest extends CakeTestCase
{
	public $fixtures = array
		(
			'plugin.feedback.article',
			'plugin.feedback.comment',
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
		$this->assertArrayNotHasKey('Comment', $this->Article->hasMany);

		$this->Article->Behaviors->load('Feedback.Commentable');
		$this->assertArrayHasKey('Comment', $this->Article->hasMany);

		$expected = array
			(
				'className'		=> 'Feedback.Comment',
				'conditions'	=> 'Comment.foreign_model = \'Article\'',
				'foreignKey'	=> 'foreign_id',
			);

		foreach ($expected as $key => $value)
		{
			$this->assertArrayHasKey($key, $this->Article->hasMany['Comment']);
			$this->assertEquals($expected[$key], $this->Article->hasMany['Comment'][$key]);
		}

		$this->Article->Behaviors->unload('Commentable');
		$this->assertArrayNotHasKey('Comment', $this->Article->hasMany);
	}

	public function testFind()
	{
		$this->Article->Behaviors->load('Feedback.Commentable');

		$result = $this->Article->find('first', array('conditions' => array('id' => 2)));
		$expected = array
			(
				'Article' => array
				(
					'id' => '2',
					'title' => 'This is my other title',
					'content' => 'But this one has no references in it. Sorry about that old chap.'
				),
				'Comment' => array
				(
					array
					(
						'id' => '3',
						'foreign_model' => 'Article',
						'foreign_id' => '2',
						'user_id' => null,
						'author_ip' => '127.0.0.1',
						'author_name' => 'newjm',
						'author_email' => 'nejmich@example.com',
						'author_website' => 'www.example.com',
						'content' => 'zis iz ze komment..',
						'created' => '2012-04-18 22:10:54'
					)
				)
			);

		$this->assertEquals($expected, $result);
		$this->Article->Behaviors->unload('Commentable');
	}
}
