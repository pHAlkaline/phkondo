<?php

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
        $this->setFilter(array('User.name'));
        $this->set('users', $this->paginate());
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
            $this->Session->setFlash(__('Invalid user'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $user = $this->User->find('first', $options);
        $this->set('user', $user);
        $this->Session->write('User.ViewID', $id);
        $this->Session->write('User.ViewName', $user['User']['name']);
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
                $this->Session->setFlash(__('The user has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->User->id));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash/error');
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
            $this->Session->setFlash(__('Invalid user'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        unset($this->request->data['User']['edpassword']);
        unset($this->request->data['User']['password']);
        unset($this->request->data['User']['verify_password']);
        $this->Session->write('User.ViewID', $id);
        $this->Session->write('User.ViewName', $this->request->data['User']['name']);
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
            $this->Session->setFlash(__('Invalid user'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User can not be deleted'), 'flash/error');
        $this->redirect(array('action' => 'view', $id));
    }

    public function login() {

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                if ($this->data['User']['language'] != '') {
                    $this->Session->write('User.language', $this->data['User']['language']);
                }
                return $this->redirect($this->Auth->redirectUrl()); //$this->Auth->redirectUrl()
            }
            $this->Session->setFlash(__('Invalid username or password, try again'), 'flash/error');
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
   public function isAuthorized($user) {

        //debug($this->request->controller);
        if (isset($user['role'])) {

            switch ($user['role']) {
                case 'admin':
                    return true;
                    break;
                case 'store_admin':
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
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'users', 'action' => 'index')), 'text' => __('Users'), 'active' => 'active'),
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[1]['active'] = '';
                $breadcrumbs[2] = array('link' => '', 'text' => $this->Session->read('User.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[1]['active'] = '';
                $breadcrumbs[2] = array('link' => '', 'text' => $this->Session->read('User.ViewName'), 'active' => 'active');
                break;
            case 'add':
                $breadcrumbs[1]['active'] = '';
                $breadcrumbs[2] = array('link' => '', 'text' => __('Add User'), 'active' => 'active');
                break;
            case 'login':
                $breadcrumbs[1] = array('link' => '', 'text' => __('Start Session'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }

}
