<?php

/**
 *
 * pHKondo : pHKondo software for condominium property managers (https://www.phalkaline.net)
 * Copyright (c) pHAlkaline . (https://www.phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (https://www.phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @package       app.Controller
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings,
                array('conditions' => array()));
        $this->setFilter(array('User.name', 'User.username'));
        $this->set('users', $this->Paginator->paginate('User'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            $this->Flash->error(__('Invalid user'));
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $user = $this->User->find('first', $options);
        $this->set('user', $user);
        $this->setPhkRequestVar('user_id', $id);
        $this->setPhkRequestVar('user_text', $user['User']['name']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                $this->redirect(array('action' => 'view', $this->User->id));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->User->exists($id)) {
            $this->Flash->error(__('Invalid user'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        unset($this->request->data['User']['edpassword']);
        unset($this->request->data['User']['password']);
        unset($this->request->data['User']['verify_password']);
        $this->setPhkRequestVar('user_id', $id);
        $this->setPhkRequestVar('user_text', $this->request->data['User']['name']);
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Flash->error(__('Invalid user'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->User->delete()) {
            $this->Flash->success(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('User can not be deleted'));
        $this->redirect(array('action' => 'view', $id));
    }

    public function login() {
        $this->__checkSetup();
        $this->__setSettings();
        $this->layout = "login";
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->rememberMe();
                return $this->redirect($this->Auth->redirectUrl()); //$this->Auth->redirectUrl()
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
        if (!isset($this->request->data['User']['language'])) {
            $this->request->data['User']['language'] = $this->Cookie->check('Config.language') ? $this->Cookie->read('Config.language') : Configure::read('Application.languageDefault');
        }
        if (!isset($this->request->data['User']['theme'])) {
            $this->request->data['User']['theme'] = $this->Cookie->check('Config.theme') ? $this->Cookie->read('Config.theme') : Configure::read('Config.theme');
        }
    }

    public function logout() {
        $this->Cookie->delete('rememberMe');
        return $this->redirect($this->Auth->logout());
    }

    /**
     * profile method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function profile() {
        if (!$this->User->exists($this->Auth->user('id'))) {
            $this->Flash->error(__('Invalid user'));
            $this->redirect(array('controller' => 'condos'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['User']['id'] = $this->Auth->user('id');
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                $this->redirect(array('action' => 'profile'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $this->Auth->user('id')));
            $this->request->data = $this->User->find('first', $options);
        }
        unset($this->request->data['User']['edpassword']);
        unset($this->request->data['User']['password']);
        unset($this->request->data['User']['verify_password']);
        $this->setPhkRequestVar('user_id', $this->Auth->user('id'));
        $this->setPhkRequestVar('user_text', $this->request->data['User']['name']);
    }

    public function rememberMe() {
        if (isset($this->request->data['User']['rememberMe']) && $this->request->data['User']['rememberMe']) {
            // After what time frame should the cookie expire
            $cookieTime = "12 months"; // You can do e.g: 1 week, 17 weeks, 14 days
            // remove "remember me checkbox"
            unset($this->request->data['User']['rememberMe']);

            // hash the user's password
            $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);

            // write the cookie
            $this->Cookie->write('rememberMe', $this->request->data['User'], true, $cookieTime);
        }
    }

    public function isAuthorized($user) {

        if (isset($user['role'])) {

            switch ($user['role']) {
                case 'admin':
                    return true;
                    break;
                case 'store_admin':
                    return true;
                    break;
                case ($this->request->action == 'profile' && Configure::read('Application.stage') != 'demo'):
                    return true;
                    break;
                default:
                    return false;
                    break;
            }
        }


        return parent::isAuthorized($user);
    }

    public function beforeRender() {
        parent::beforeRender();
        $headerTitle = __('Users');
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'users', 'action' => 'index')), 'text' => __('Users'), 'active' => 'active'),
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[0]['active'] = '';
                $breadcrumbs[1] = array('link' => '', 'text' => $this->getPhkRequestVar('user_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[0]['active'] = '';
                $breadcrumbs[1] = array('link' => '', 'text' => $this->getPhkRequestVar('user_text'), 'active' => 'active');
                break;
            case 'add':
                //$breadcrumbs[0]['active'] = '';
                //$breadcrumbs[1] = array('link' => '', 'text' => __('Add User'), 'active' => 'active');
                break;
            case 'login':
                $breadcrumbs[0] = array('link' => '', 'text' => __('Start Session'), 'active' => 'active');
                $headerTitle = __('Start Session');
                break;
        }

        $this->set(compact('breadcrumbs', 'headerTitle'));
    }

    private function __setSettings() {
        if (isset($this->request->data['User']['theme']) && $this->request->data['User']['theme']!='') {
            App::uses('Folder', 'Utility');
            $theme_path = APP . 'View' . DS . 'Themed' . DS . $this->request->data['User']['theme'];
            $folder = new Folder($theme_path);
            if (is_null($folder->path)) {
                $this->Cookie->delete('Config.theme');
                Configure::write('Theme.name', 'Phkondo');
                $this->Flash->error(__('Selected Theme not found.'));
            }
            $this->Cookie->write('Config.theme', $this->request->data['User']['theme'], true, "12 months");
            Configure::write('Config.theme', $this->request->data['User']['theme']);
        } 
        if (isset($this->request->data['User']['language']) && $this->request->data['User']['language'] != '') {
            $this->Cookie->write('Config.language', $this->request->data['User']['language'], false, "12 months");
            Configure::write('Config.language', $this->request->data['User']['language']);
        }
    }

    private function __checkSetup() {
        if (!file_exists(APP . 'Config' . DS . 'database.php')) {
            $this->Flash->error(__d('install', 'Database connection missing'));
            $this->Flash->info(__d('install', 'Install or manually config pHKondo'));
            $this->redirect('/');
        }
    }

}
