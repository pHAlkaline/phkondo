<?php

/**
 *
 * pHKondo : pHKondo software for condominium hoa association management (https://phalkaline.net)
 * Copyright (c) pHAlkaline . (https://phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (https://phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @package       app.Controller
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Condo', 'Model');
App::uses('Receipt', 'Model');
App::uses('CakeEmail', 'Network/Email');

/**
 * Email Controller
 *
 * @property PaginatorComponent $Paginator
 */
class SystemConfigController extends AppController
{

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
    );

    /**
     * Components
     *
     * @var array
     */
    public $components = array('RequestHandler');

    public function email()
    {
        $this->set('title_for_layout', __('Email'));
        $this->set('title_for_step', __('Email'));
        if (empty($this->request->data)) {
            return;
        }

        $config = $this->defaultEmail;
        foreach ($this->request->data as $key => $value) {
            if (isset($config[$key])) {
                $config[$key] = h($value);
            }
        }

        copy(APP . 'Config' . DS . 'email.php.default', APP . 'Config' . DS . 'email.php');
        $file = new File(APP . 'Config' . DS . 'email.php', true);
        $content = $file->read();

        foreach ($config as $configKey => $configValue) {
            $content = str_replace('{default_' . $configKey . '}', h($configValue), $content);
        }

        if (!$file->write($content)) {
            $this->Flash->error(__d('email', 'Could not save email client settings.'));
            return;
        }


        foreach ($this->request->data as $key => $value) {
            if (Configure::check('EmailNotifications.' . $key)) {
                Configure::write('EmailNotifications.' . $key, h($value));
            }
        }

        Configure::write('EmailNotifications.active', true);
        if (!Configure::dump('email_notifications.php', 'default', array('EmailNotifications'))) {
            $this->Flash->error(__d('email', 'Could not save notification settings.'));
            return;
        }


        $this->Flash->success(__d('email', 'Config saved with success.'));
        if ($this->request->data['test']) {
            $this->_sendTest();
        }
        $this->redirect(array('action' => 'email'));
    }

    public function general()
    {
        $this->set('title_for_layout', __('General'));
        $this->set('title_for_step', __('General'));
        if (empty($this->request->data)) {
            return;
        }
        $data = $this->request->data;
        //$data['BootstrapApp']['Attachment']['attachment']['extensions'] = explode(',', trim($data['BootstrapApp']['Attachment']['attachment']['extensions']));
       // $data['BootstrapApp']['Attachment']['attachment']['extensions'] = $data['BootstrapApp']['Attachment']['attachment']['extensions'];
        

        Configure::write('BootstrapApp.Application.currencySign','\''.$data['BootstrapApp']['Application']['currencySign'].'\'');
        Configure::write('BootstrapApp.Application.calendarDateFormat',$data['BootstrapApp']['Application']['calendarDateFormat'] );
        Configure::write('BootstrapApp.Config.timezone',$data['BootstrapApp']['Config']['timezone'] );
        Configure::write('BootstrapApp.Attachment.attachment.maxSize',$data['BootstrapApp']['Attachment']['attachment']['maxSize'] );
        Configure::write('BootstrapApp.Attachment.attachment.extensions',$data['BootstrapApp']['Attachment']['attachment']['extensions'] );

        if (!Configure::dump('bootstrap_app.ini', 'BootstrapApp', array('BootstrapApp'))) {
            $this->Flash->error(__d('install', 'Unable to config your application, your Config %s bootstrap_app.ini file is not writable. Please check the permissions.', DS));
            $this->log(__d('install', 'Unable to config your application, your Config %s bootstrap_app.ini file is not writable. Please check the permissions.', DS));
        } else {
            $this->Flash->success(__d('email', 'Config saved with success.'));
        }

        $this->redirect(array('action' => 'general'));
    }

    public function beforeRender()
    {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'system_config', 'action' => 'email')), 'text' => __('Email'), 'active' => 'active')
        );
        switch ($this->action) {
            case 'email':
                $breadcrumbs[0] = array('link' => Router::url(array('controller' => 'system_config', 'action' => 'email')), 'text' => __('Email'), 'active' => 'active');
                $headerTitle = __('Email');
                $Email = new CakeEmail();
                $Email->config('default');
                $emailClient = $Email->config();
                $emailNotifications = Configure::read('EmailNotifications');
                $this->set(compact('breadcrumbs', 'headerTitle', 'emailClient', 'emailNotifications'));
                break;
            case 'general':
                $breadcrumbs[0] = array('link' => Router::url(array('controller' => 'system_config', 'action' => 'general')), 'text' => __('General'), 'active' => 'active');
                $headerTitle = __('General');
                $this->set(compact('breadcrumbs', 'headerTitle'));
                break;
        }
    }

    public function isAuthorized($user)
    {

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

    private function _sendTest()
    {
        if (!extension_loaded('openssl')) {
            throw new Exception('This app needs the Open SSL PHP extension.');
        }
        try {
            $Email = new CakeEmail();
            $Email->from(array($this->request->data['email'] => $this->request->data['name']))
                ->sender($this->request->data['email'], $this->request->data['name'])
                ->to($this->request->data['email'])
                ->subject($this->request->data['subject'])
                ->send(__d('email', 'Test message'));
            $this->Flash->success(__d('email', 'Email sent with success.'));
        } catch (\Exception $e) {
            $this->Flash->error($e->getMessage());
        }
    }
}
