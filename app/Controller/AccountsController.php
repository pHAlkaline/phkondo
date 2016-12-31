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
        $options['conditions'] = array('Account.condo_id' => $this->getPhkRequestVar('condo_id'));
        //$options['order'] = null;
        
        
        if (isset($this->Paginator->settings['conditions'])) {
            $options['conditions'] = array_replace_recursive($this->Paginator->settings['conditions'], $options['conditions']);
        }
        
       
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings ,  array(
            'conditions' => $options['conditions']));
        $this->setFilter(array('Account.title', 'Account.bank', 'Account.balcony'));
        $this->set('accounts', $this->Paginator->paginate('Account'));
        
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
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $options = array('conditions' => array('Account.id'=> $id));
        $account = $this->Account->find('first', $options);
        $this->set(compact('account'));
        $this->setPhkRequestVar('account_id', $id);
        $this->setPhkRequestVar('account_text', $account['Account']['title']);
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
                $this->redirect(array('action' => 'view', $this->Account->id,'?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The account could not be saved. Please, try again.'));
            }
        }
        $condos = $this->Account->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
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
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Account->save($this->request->data)) {
                $this->Flash->success(__('The account has been saved'));
                $this->redirect(array('action' => 'view', $id, '?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The account could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Account.id' => $id));
            $this->request->data = $this->Account->find('first', $options);
        }
        $condos = $this->Account->Condo->find('list');
        $this->set(compact('condos'));
        $this->setPhkRequestVar('account_id', $id);
        $this->setPhkRequestVar('account_text', $this->request->data['Account']['title']);
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
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        
        if ($this->Account->delete()) {
            $this->Flash->success(__('Account deleted'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        
        $this->Flash->error(__('Account can not be deleted'));
        $this->redirect(array('action' => 'view', $id,'?'=>$this->request->query));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('condo_id') || !$this->getPhkRequestVar('has_fiscal_year')) {
            $this->Flash->error(__('Invalid condo or fiscal year'));
            $this->redirect(array('controller' => 'condos', 'action' => 'index'));
        }
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index'),true), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index'),true), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id')),true), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => '', 'text' => __n('Account','Accounts',2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'accounts', 'action' => 'index','?'=>$this->request->query),true), 'text' => __n('Account','Accounts',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('account_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'accounts', 'action' => 'index','?'=>$this->request->query),true), 'text' => __n('Account','Accounts',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('account_text'), 'active' => 'active');
                break;
        }
        $headerTitle=__n('Account','Accounts',2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
