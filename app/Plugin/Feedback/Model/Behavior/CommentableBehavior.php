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

App::uses('ModelBehavior', 'Model');

class CommentableBehavior extends ModelBehavior
{
	public function setup(Model $Model, $config = array())
	{
		$Model->bindModel
			(
				array
				(
					'hasMany' => array
					(
						'Comment' => array
						(
							'className'		=> 'Feedback.Comment',
							'conditions'	=> sprintf('Comment.foreign_model = \'%s\'', $Model->name),
							'foreignKey'	=> 'foreign_id',
						)
					)
        		),
				false
			);
	}

	public function cleanup(Model $Model)
	{
		$Model->unbindModel(array('hasMany' => array('Comment')), false);
	}
}
