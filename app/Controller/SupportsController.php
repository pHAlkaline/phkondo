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
 * @since         pHKondo v 2.3
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');

/**
 * Supports Controller
 *
 * @property Support $Support
 * @property PaginatorComponent $Paginator
 */
class SupportsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Feedback.Comments' => array('on' => array('view')));

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Paginator->settings = $this->Paginator->settings + array(
            'conditions' => array('Support.condo_id' => $this->getPhkRequestVar('condo_id'))
        );
        $this->setFilter(array('Support.title'));
        $this->set('supports', $this->Paginator->paginate('Support'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Support->exists($id)) {
            $this->Flash->error(__('Invalid support'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $options = array('conditions' => array('Support.' . $this->Support->primaryKey => $id));
        $support = $this->Support->find('first', $options);
        $this->set(compact('support'));
        $this->setPhkRequestVar('support_id',$id);
        $this->setPhkRequestVar('support_text',$support['Support']['title']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Support->create();
            if ($this->Support->save($this->request->data)) {
                $this->Flash->success(__('The support has been saved.'));
                return $this->redirect(array('action' => 'index', '?' => $this->request->query));
            } else {
                $this->Flash->error(__('The support could not be saved. Please, try again.'));
            }
        }
        $condos = $this->Support->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $fractions = $this->Support->Fraction->find('list', array('conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));
        $supportCategories = $this->Support->SupportCategory->find('list', array('conditions' => array('active' => 1)));
        $supportPriorities = $this->Support->SupportPriority->find('list', array('order' => array('order'), 'conditions' => array('active' => 1)));
        $supportStatuses = $this->Support->SupportStatus->find('list', array('conditions' => array('active' => 1)));
        $entities = $this->Support->Entity->find('list');
        $users = $this->Support->User->find('list', array('conditions' => array('active' => 1)));
        $this->set(compact('condos', 'fractions', 'supportCategories', 'supportPriorities', 'supportStatuses', 'entities', 'users'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Support->exists($id)) {
            throw new NotFoundException(__('Invalid support'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Support->save($this->request->data)) {
                $this->Flash->success(__('The support has been saved.'));
                return $this->redirect(array('action' => 'index', '?' => $this->request->query));
            } else {
                $this->Flash->error(__('The support could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Support.' . $this->Support->primaryKey => $id));
            $this->request->data = $this->Support->find('first', $options);
        }
        $condos = $this->Support->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $fractions = $this->Support->Fraction->find('list', array('conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));
        $supportCategories = $this->Support->SupportCategory->find('list', array('conditions' => array('active' => 1)));
        $supportPriorities = $this->Support->SupportPriority->find('list', array('order' => array('order'), 'conditions' => array('active' => 1)));
        $supportStatuses = $this->Support->SupportStatus->find('list', array('conditions' => array('active' => 1)));
        $entities = $this->Support->Entity->find('list');
        $users = $this->Support->User->find('list', array('conditions' => array('active' => 1)));
        $this->set(compact('condos', 'fractions', 'supportCategories', 'supportPriorities', 'supportStatuses', 'entities', 'users'));
        $this->setPhkRequestVar('support_id',$id);
        $this->setPhkRequestVar('support_text',$this->request->data['Support']['title']);
        
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

        $this->Support->id = $id;
        if (!$this->Support->exists()) {
            $this->Flash->error(__('Invalid Support'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }

        if ($this->Support->delete()) {
            $this->Flash->success(__('Support deleted'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $this->Flash->error(__('Support can not be deleted'));
        $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('condo_id')) {
            $this->Flash->error(__('Invalid condo or fiscal year'));
            $this->redirect(array('controller' => 'condos', 'action' => 'index'));
        }
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo', 'Condos', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => '', 'text' => __n('Support', 'Supports', 2), 'active' => 'active')
        );

        switch ($this->action) {
            case 'view':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'supports', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Support', 'Supports', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('support_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'supports', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Support', 'Supports', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('support_text'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }

}
