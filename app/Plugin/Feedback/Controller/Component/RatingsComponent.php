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

App::uses('Component', 'Controller');

/**
 * @property SessionComponent $Session
 * @property CookieComponent $Cookie
 */
class RatingsComponent extends Component
{
	public $components = array('Session', 'Cookie');

	private $_defaultSettings = array('on' => array('view', 'index'), 'models' => array());
	public $models = array();

	public function __construct(ComponentCollection $collection, $settings = array())
	{
		parent::__construct($collection, $settings);
		$this->settings = array_merge($this->_defaultSettings, $settings);
	}

	public function initialize(Controller $controller)
	{
		if (empty($this->models))
		{
			$plugin = '';

			// due to cake creating models on the fly instead of looking for models
			// in all the loaded plugins (why??), we have to hack our way through so we can
			// get the *real* model with the attached RatedBehavior.
			if (!empty($controller->plugin))
			{
				$plugin = $controller->plugin.'.';
			}

			$this->models[$controller->modelClass] = $plugin.$controller->modelClass;
		}
	}

	public function beforeRender(Controller $controller)
	{
		if (!in_array($controller->request->params['action'], (array)$this->settings['on']))
		{
			return;
		}

		$this->Session->write('Feedback.RatingModels', $this->models);

		foreach ($this->models as $modelClass => $model)
		{
			$data = $this->readRatingCookie($modelClass);
			$this->Session->write('Feedback.'.$modelClass.'Ratings', $data);
		}

		if (!in_array('Feedback.Ratings', $controller->helpers))
		{
			$controller->helpers[] = 'Feedback.Ratings';
		}

		parent::beforeRender($controller);
	}

	public function writeRatingCookie($modelName, $data = array())
	{
		$this->Cookie->write('Feedback.'.$modelName.'Ratings', $data, false, '+5 years');
	}

	public function readRatingCookie($modelName)
	{
		$raw = $this->Cookie->read('Feedback.'.$modelName.'Ratings');
		return (!empty($raw) ? $raw : array());
	}
}
