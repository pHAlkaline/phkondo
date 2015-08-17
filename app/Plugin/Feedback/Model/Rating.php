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

App::uses('FeedbackAppModel', 'Feedback.Model');
App::uses('Hash', 'Utility');


class Rating extends FeedbackAppModel
{
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array
		(
			'foreign_model' => array
			(
				'notBlank' => array
				(
					'rule' => array('notBlank'),
					//'message' => 'Your custom message here',
					'allowEmpty' => false,
					'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'foreign_id' => array
			(
				'notBlank' => array
				(
					'rule' => array('notBlank'),
					//'message' => 'Your custom message here',
					'allowEmpty' => false,
					'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'rating' => array
			(
				'notBlank' => array
				(
					'rule' => array('notBlank'),
					//'message' => 'Your custom message here',
					'allowEmpty' => false,
					'required' => true,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
				'decimal' => array
				(
					'rule' => array('decimal'),
				),
				'minimum' => array
				(
					'rule' => array('comparison', '>=', 0.5),
				),
				'maximum' => array
				(
					'rule' => array('comparison', '<=', 5),
				),
			),
		);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $actsAs = array
		(
			'Feedback.Polymorphic' => array
			(
				'modelField'	=> 'foreign_model',
				'foreignKey'	=> 'foreign_id'
			),
		);
}
