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

App::uses('HoneypotBehavior', 'Feedback.Model/Behavior');

/**
 * HoneypotBehavior Test Case
 *
 * @property Model $Model
 */
class HoneypotBehaviorTest extends CakeTestCase
{
	public $fixtures = array
		(
			'plugin.feedback.article',
			'plugin.feedback.comment',
		);

	private $_behaviorSettings = array
		(
			'field' => 'hairy_potter',
			'message' => 'Your email is clearly invalid',
			'errorField' => 'author_email'
		);

	public function setUp()
	{
		parent::setUp();

		$this->Model = ClassRegistry::init('Feedback.Comment');
	}

	public function tearDown()
	{
		unset($this->Model);

		parent::tearDown();
	}

	public function testBeforeValidateMissingField()
	{
		$this->Model->Behaviors->load('Feedback.Honeypot', $this->_behaviorSettings);

		$input = array
			(
				'Comment' => array
				(
					'author_name' => 'Dougal McGuire',
					'author_email' => 'dougal@doogle.com',
					'content' => 'FECK! ARSE! DRINK!',
				),
			);

		$save_result = $this->Model->save($input);
		$validation_errors = $this->Model->validationErrors;

		$expected = array
			(
				'author_email' => array($this->_behaviorSettings['message'])
			);

		$this->assertFalse($save_result);
		$this->assertEquals($expected, $validation_errors);
	}

	public function testBeforeValidateHoneypotNotEmpty()
	{
		$this->Model->Behaviors->load('Feedback.Honeypot', $this->_behaviorSettings);

		$input = array
			(
				'Comment' => array
				(
					'author_name' => 'Dougal McGuire',
					'author_email' => 'dougal@doogle.com',
					'content' => 'FECK! ARSE! DRINK!',
					'hairy_potter' => 'HAHAHA, IMASPAMMARR!!!',
				),
			);

		$save_result = $this->Model->save($input);
		$validation_errors = $this->Model->validationErrors;

		$expected = array
			(
				'author_email' => array($this->_behaviorSettings['message'])
			);

		$this->assertFalse($save_result);
		$this->assertEquals($expected, $validation_errors);
	}

	public function testBeforeValidateHoneypotEmpty()
	{
		$this->Model->Behaviors->load('Feedback.Honeypot', $this->_behaviorSettings);

		$input = array
			(
				'Comment' => array
				(
					'foreign_model' => 'Article',
					'foreign_id' => 1,
					'author_name' => 'Dougal McGuire',
					'author_email' => 'dougal@doogle.com',
					'content' => 'FECK! ARSE! DRINK!',
					'hairy_potter' => '',
				),
			);

		$expected = array(); 
		$save_result = $this->Model->save($input);
		$validation_errors = $this->Model->validationErrors;

		$this->assertArrayHasKey('id', $save_result['Comment']);
		$this->assertEquals($expected, $validation_errors);
	}
}
