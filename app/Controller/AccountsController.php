<?php

App::uses('AppController', 'Controller');

/**
 * Accounts Controller
 *
 * @property Account $Account
 * @property PaginatorComponent $Paginator
 */
class AccountsController extends AppController {

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
        $this->Account->recursive = 0;
        $this->Paginator->settings = $this->paginate + array(
            'conditions' => array('Account.condo_id' => $this->Session->read('Condo.ViewID'))
        );
        $this->setFilter(array('Account.title', 'Account.bank', 'Account.balcony'));

        $this->set('accounts', $this->paginate());
        $this->Session->delete('Condo.Account');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Account->exists($id)) {
            $this->Session->setFlash(__('Invalid account'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('Account.' . $this->Account->primaryKey => $id));
        $account = $this->Account->find('first', $options);
        $this->set(compact('account'));
        $this->Session->write('Condo.Account.ViewID', $id);
        $this->Session->write('Condo.Account.ViewName', $account['Account']['title']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Account->create();
            if ($this->Account->save($this->request->data)) {
                $this->Session->setFlash(__('The account has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Account->id));
            } else {
                $this->Session->setFlash(__('The account could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $condos = $this->Account->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $this->set(compact('condos'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Account->exists($id)) {
            $this->Session->setFlash(__('Invalid account'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Account->save($this->request->data)) {
                $this->Session->setFlash(__('The account has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Account->id));
            } else {
                $this->Session->setFlash(__('The account could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array('Account.' . $this->Account->primaryKey => $id));
            $this->request->data = $this->Account->find('first', $options);
        }
        $condos = $this->Account->Condo->find('list');
        $this->set(compact('condos'));
        $this->Session->write('Condo.Account.ViewID', $id);
        $this->Session->write('Condo.Account.ViewName', $this->request->data['Account']['title']);
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
        $this->Account->id = $id;
        if (!$this->Account->exists()) {
            $this->Session->setFlash(__('Invalid account'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Account->delete()) {
            $this->Session->setFlash(__('Account deleted'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Account can not be deleted'), 'flash/error');
        $this->redirect(array('action' => 'view', $id));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Condo.ViewID') || !$this->Session->read('Condo.FiscalYearID')) {
            $this->Session->setFlash(__('Invalid condo or fiscal year'), 'flash/error');
            $this->redirect(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID')));
        }
    }

    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index'),true), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index'),true), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID')),true), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __n('Account','Accounts',2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'accounts', 'action' => 'index'),true), 'text' => __n('Account','Accounts',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->Session->read('Condo.Account.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'accounts', 'action' => 'index'),true), 'text' => __n('Account','Accounts',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->Session->read('Condo.Account.ViewName'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }

}
