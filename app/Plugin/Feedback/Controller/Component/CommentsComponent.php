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
 * @property CookieComponent $Cookie
 */
class CommentsComponent extends Component
{
	public $components = array('Cookie');

	private $_defaultSettings = array('on' => 'view');

	public function __construct(ComponentCollection $collection, $settings = array())
	{
		parent::__construct($collection, $settings);
		$this->settings = array_merge($this->_defaultSettings, $settings);
	}

	public function beforeRender(Controller $controller)
	{
		if (!in_array($controller->request->params['action'], (array)$this->settings['on']))
		{
			return;
		}
		
		if (!in_array('Feedback.Comments', $controller->helpers))
		{
			$controller->helpers[] = 'Feedback.Comments';
		}

		$cookie_data = $this->Cookie->read('Feedback.CommentInfo');

		if (!empty($cookie_data))
		{
			foreach ($cookie_data as $field => $value)
			{
				$controller->request->data['Comment'][$field] = $value;
			}
		}
	}

	public function saveInfo()
	{
		$data = $this->_Collection->getController()->request->data;

		$info = array();
		$info['author_name'] = $data['Comment']['author_name'];
		$info['author_email'] = $data['Comment']['author_email'];
		$info['author_website'] = $data['Comment']['author_website'];
		$info['remember_info'] = $data['Comment']['remember_info'];

		$this->Cookie->write('Feedback.CommentInfo', $info, false, '+1 year');
	}

	public function forgetInfo()
	{
		$this->Cookie->delete('Feedback.CommentInfo');
	}
}
