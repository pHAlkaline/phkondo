<?php
/**
 *
 * pHKondo : pHKondo software for condominium property managers (http://phalkaline.eu)
 * Copyright (c) pHAlkaline . (http://phalkaline.eu)
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
 * @copyright     Copyright (c) pHAlkaline . (http://phalkaline.eu)
 * @link          http://phkondo.net pHKondo Project
 * @package       app.Controller
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */

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
        $this->setFilter(array('Account.title', 'Account.bank', 'Account.balcony'));
        
        $options['conditions'] = array('Account.condo_id' => $this->Session->read('Condo.ViewID'));
        //$options['order'] = null;
        
        
        if (isset($this->paginate['conditions'])) {
            $options['conditions'] = array_merge($this->paginate['conditions'], $options['conditions']);
        }
        
        /*if (isset($this->paginate['order'])) {
            $options['order'] = array_merge($this->paginate['order'], $options['order']);
        }*/
        
        $this->Paginator->settings = array(
            'Account' => array(
                'conditions' => $options['conditions'],
                //'requiresAcessLevel' => true,
                //'contain' => null
                ));
        
        $this->set('accounts', $this->paginate('Account'));
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
            $this->Flash->error(__('Invalid account'));
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
                $this->Flash->success(__('The account has been saved'));
                $this->redirect(array('action' => 'view', $this->Account->id));
            } else {
                $this->Flash->error(__('The account could not be saved. Please, try again.'));
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
            $this->Flash->error(__('Invalid account'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Account->save($this->request->data)) {
                $this->Flash->success(__('The account has been saved'));
                $this->redirect(array('action' => 'view', $this->Account->id));
            } else {
                $this->Flash->error(__('The account could not be saved. Please, try again.'));
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
            $this->Flash->error(__('Invalid account'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Account->delete()) {
            $this->Flash->success(__('Account deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Account can not be deleted'));
        $this->redirect(array('action' => 'view', $id));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Condo.ViewID') || !$this->Session->read('Condo.FiscalYearID')) {
            $this->Flash->error(__('Invalid condo or fiscal year'));
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
