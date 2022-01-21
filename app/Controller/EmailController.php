<?php

/**
 *
 * pHKondo : pHKondo software for condominium property managers (http://phalkaline.net)
 * Copyright (c) pHAlkaline . (http://phalkaline.net)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @copyright     Copyright (c) pHAlkaline . (http://phalkaline.net)
 * @link          http://phkondo.net pHKondo Project
 * @package       app.Controller
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Condo', 'Model');
App::uses('Receipt', 'Model');

/**
 * Email Controller
 *
 * @property PaginatorComponent $Paginator
 */
class EmailController extends AppController {

    public $useModel = false;
    /*
     * Default email configuration
     * 
     * @var array
     * @access public
     */
    public $defaultEmail = array(
        'sender_email' => 'noreply@yourdomain.com',
        'email' => 'noreply@yourdomain.com',
        'name' => 'reply to',
        'subject' => 'pHKondo Notification',
        'host' => '',
        'port' => '',
        'username' => '',
        'password' => '',
        'receipt_subject' => '',
        'receipt_message' => ''
    );

    /**
     * Components
     *
     * @var array
     */
    public $components = array('RequestHandler');

    public function config() {
        $this->set('title_for_layout', __('Email'));
        $this->set('title_for_step', __('Email'));
          
        if (empty($this->request->data)) {
            return;
        }

        $config = $this->defaultEmail;
        foreach ($this->request->data as $key => $value) {
            if (isset($config[$key])) {
                $config[$key] = $value;
            }
        }
        copy(APP . 'Config' . DS . 'email.php.default', APP . 'Config' . DS . 'email.php');
        $file = new File(APP . 'Config' . DS . 'email.php', true);
        $content = $file->read();

        foreach ($config as $configKey => $configValue) {
            $content = str_replace('{default_' . $configKey . '}', $configValue, $content);
        }

        if (!$file->write($content)) {
            $this->Flash->error(__('Could not write email.php file.'));
            return;
        }
        $this->Flash->success(__('Config saved with success.'));
        $this->redirect(array('action' => 'config'));
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            //array('link' => Router::url(array('controller' => 'pages', 'action' => 'home')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'email', 'action' => 'config')), 'text' => __('Email'), 'active' => 'active'));

        $headerTitle = __('Email');
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->config('default');
        $config = $Email->config();
      
        $this->set(compact('breadcrumbs', 'headerTitle', 'config'));
    }

    public function isAuthorized($user) {

        if (isset($user['role'])) {
            switch ($user['role']) {
                case 'admin':
                    return true;
                    break;
                case 'store_admin':
                    return false;
                    break;
                default:
                    return false;
                    break;
            }
        }


        return parent::isAuthorized($user);
    }

}
