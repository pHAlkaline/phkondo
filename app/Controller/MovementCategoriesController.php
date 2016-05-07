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
 * MovementCategories Controller
 *
 * @property MovementCategory $MovementCategory
 * @property PaginatorComponent $Paginator
 */
class MovementCategoriesController extends AppController {

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
        $this->setFilter(array('MovementCategory.name'));
        $this->set('movementCategories', $this->Paginator->paginate('MovementCategory'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->MovementCategory->exists($id)) {
            $this->Flash->error(__('Invalid movement category'));
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('MovementCategory.' . $this->MovementCategory->primaryKey => $id));
        $movementCategory = $this->MovementCategory->find('first', $options);
        $this->set('movementCategory', $movementCategory);
        
        $this->setPhkRequestVar('movement_category_id', $id);
        $this->setPhkRequestVar('movement_category_text', $movementCategory['MovementCategory']['name']);
        
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->MovementCategory->create();
            if ($this->MovementCategory->save($this->request->data)) {
                $this->Flash->success(__('The movement category has been saved'));
                $this->redirect(array('action' => 'view', $this->Movement->id));
            } else {
                $this->Flash->error(__('The movement category could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * addFromMovement method
     *
     * @return void
     */
    public function addFromMovement($movementId = null) {
        $this->Movement = ClassRegistry::init('Movement');
        if ($movementId != null && !$this->Movement->exists($movementId)) {
            $this->Flash->error(__('Invalid movement category'));
            $this->redirect(array('controller' => 'movements', 'action' => 'index','?'=>$this->request->query));
        }
        if ($this->request->is('post')) {
            $this->MovementCategory->create();
            if ($this->MovementCategory->save($this->request->data)) {
                $this->Flash->success(__('The movement category has been saved'));
                if ($movementId != null) {
                    $this->redirect(array('controller' => 'movements', 'action' => 'edit', $movementId,'?'=>$this->request->query));
                } else {
                    $this->redirect(array('controller' => 'movements', 'action' => 'add','?'=>$this->request->query));
                }
            } else {
                $this->Flash->error(__('The movement category could not be saved. Please, try again.'));
            }
        }

        if (!$this->getPhkRequestVar('account_id')) {
            $this->Flash->error(__('Invalid account'));
            $this->redirect(array('controller' => 'accounts', 'action' => 'index'));
        }

        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo', 'Condos', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'accounts', 'action' => 'index','?'=>array('condo_id'=>$this->getPhkRequestVar('condo_id')))), 'text' => __n('Account', 'Accounts', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'accounts', 'action' => 'view', $this->getPhkRequestVar('account_id'),'?'=>array('condo_id'=>$this->getPhkRequestVar('condo_id')))), 'text' => $this->getPhkRequestVar('account_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'movements', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Movement', 'Movements', 2), 'active' => ''),
            array('link' => '', 'text' => __('Add Movement Category'), 'active' => 'active')
        );
        $this->set(compact('breadcrumbs', 'movementId'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->MovementCategory->exists($id)) {
            $this->Flash->error(__('Invalid movement category'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->MovementCategory->save($this->request->data)) {
                $this->Flash->success(__('The movement category has been saved'));
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Flash->error(__('The movement category could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MovementCategory.' . $this->MovementCategory->primaryKey => $id));
            $this->request->data = $this->MovementCategory->find('first', $options);
        }
        $this->setPhkRequestVar('movement_category_id', $id);
        $this->setPhkRequestVar('movement_category_text',  $this->request->data['MovementCategory']['name']);
        
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
        $this->MovementCategory->id = $id;
        if (!$this->MovementCategory->exists()) {
            $this->Flash->error(__('Invalid movement category'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->MovementCategory->delete()) {
            $this->Flash->success(__('Movement category deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Movement category can not be deleted'));
        $this->redirect(array('action' => 'view', $id));
    }

    public function beforeRender() {
        parent::beforeRender();
        if (isset($this->viewVars['breadcrumbs'])) {
            return;
        }
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => '', 'text' => __('Movement Categories'), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'movement_categories', 'action' => 'index')), 'text' => __('Movement Categories'), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('movement_category_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'movement_categories', 'action' => 'index')), 'text' => __('Movement Categories'), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('movement_category_text'), 'active' => 'active');

                break;
        }
        $headerTitle=__('Movement Categories');
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
