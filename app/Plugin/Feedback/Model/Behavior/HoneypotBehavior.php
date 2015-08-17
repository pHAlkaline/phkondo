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

class HoneypotBehavior extends ModelBehavior
{
	public function setup(Model $Model, $config = array())
	{
		if (!isset($this->settings[$Model->alias]))
		{
			$this->settings[$Model->alias] = array('field' => '', 'message' => '', 'errorField' => '');
		}

		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $config);
	}

	public function beforeValidate(Model $Model, $options = array())
	{
		extract($this->settings[$Model->alias]);

		if (!isset($Model->data[$Model->alias][$field]) || !empty($Model->data[$Model->alias][$field]))
		{
			$Model->invalidate($errorField, $message);
			$this->log('HoneypotBehavior::beforeValidate() caught: '.serialize($Model->data));
			return false;
		}

		return true;
	}
}
