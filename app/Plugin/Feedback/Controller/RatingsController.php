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

App::uses('FeedbackAppController', 'Feedback.Controller');
/**
 * Ratings Controller
 * 
 * @property RatingsComponent $Ratings
 * @property Rating $Rating
 */
class RatingsController extends FeedbackAppController
{
	public $components = array('Feedback.Ratings');

	public function beforeFilter()
	{
		parent::beforeFilter();

		if ($this->request->params['action'] == 'add')
		{
			$this->viewClass = 'Json';
			$this->response->type('json');
		}
	}

	public function add($foreign_model = null, $foreign_id = null)
	{
		if (empty($foreign_model) ||
			empty($foreign_id) ||
			!$this->request->is('post') ||
			!$this->request->is('ajax')
			)
		{
			return $this->redirect('/');
		}

		list($model, $modelClass) = $this->parseModel($foreign_model);

		App::uses($model, 'Model');
		$this->loadModel($model);

		if (!($this->{$modelClass} instanceof $modelClass))
		{
			return $this->redirect('/');
		}

		$row_exists = $this->{$modelClass}->hasAny
			(
				array($this->{$modelClass}->primaryKey => $foreign_id)
			);

		if (!$row_exists)
		{
			return $this->redirect('/');
		}

		$cookie = $this->Ratings->readRatingCookie($modelClass);

		if (isset($cookie[$foreign_id]))
		{
			$output = array
				(
					'success' => false,
					'message' => __d('feedback','You cannot vote more than once!'),
					'data' => array(),
				);

			$this->set('output', $output);
			return;
		}

		if (!isset($this->request->data['Rating']['foreign_model']) ||
			!isset($this->request->data['Rating']['foreign_id']) ||
			$this->request->data['Rating']['foreign_model'] != $modelClass ||
			$this->request->data['Rating']['foreign_id'] != $foreign_id)
		{
			return $this->redirect('/');
		}

		$this->request->data['Rating']['foreign_model'] = $this->{$modelClass}->name;
		$this->request->data['Rating']['foreign_id'] = $foreign_id;
		$this->request->data['Rating']['author_ip'] = $this->request->clientIp();

		$this->Rating->create();

		if (!$this->Rating->save($this->request->data))
		{
			$this->log(serialize($this->Rating->validationErrors));

			$output = array
				(
					'success' => false,
					'message' => __d('feedback','There was an error while saving your vote.'),
					'data' => array(),
				);
			$this->set('output', $output);
			return;
		}

		$cookie[$foreign_id] = $this->request->data['Rating']['rating'];
		$this->Ratings->writeRatingCookie($modelClass, $cookie);

		$updated = $this->{$modelClass}->read(null, $foreign_id);

		$output = array
			(
				'success' => true,
				'message' => __d('feedback','Thanks for voting!'),
				'data' => $updated['RatingSummary'],
			);
		$this->set('output', $output);
	}

	/**
	 * Takes input in form of a model name, with or without the plugin:
	 *
	 *  'Post'
	 *  'Blog.Post'
	 *
	 * Returns an array of model path and model class:
	 *
	 *  array('Post', 'Post')
	 *  array('Blog.Post', 'Post')
	 *
	 * @param string $model
	 * @return array An array of model path and model class.
	 */
	private function parseModel($model)
	{
		if (strpos($model, '.') === false)
		{
			return array($model, $model);
		}

		list($model, $modelClass) = pluginSplit($model, true);
		$model .= $modelClass;

		return array($model, $modelClass);
	}
}
