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
 * @since         pHKondo v 1.2.3
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');

/**
 * InsuranceTypes Controller
 *
 * @property InsuranceType $InsuranceType
 * @property PaginatorComponent $Paginator
 */
class InsuranceTypesController extends AppController {

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
        $this->setFilter(array('InsuranceType.name'));
        $this->set('insuranceTypes', $this->Paginator->paginate('InsuranceType'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->InsuranceType->exists($id)) {
            $this->Flash->error(__('Invalid insurance type'));
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('InsuranceType.' . $this->InsuranceType->primaryKey => $id));
        $insuranceType = $this->InsuranceType->find('first', $options);
        $this->set('insuranceType', $insuranceType);
        $this->setPhkRequestVar('insurance_type_id', $id);
        $this->setPhkRequestVar('insurance_type_text', $insuranceType['InsuranceType']['name']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->InsuranceType->create();
            if ($this->InsuranceType->save($this->request->data)) {
                $this->Flash->success(__('The insurance type has been saved'));
                $this->redirect(array('action' => 'view', $this->InsuranceType->id));
            } else {
                $this->Flash->error(__('The insurance type could not be saved. Please, try again.'));
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
        if (!$this->InsuranceType->exists($id)) {
            $this->Flash->error(__('Invalid insurance types'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->InsuranceType->save($this->request->data)) {
                $this->Flash->success(__('The insurance type has been saved'));
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Flash->error(__('The insurance type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('InsuranceType.' . $this->InsuranceType->primaryKey => $id));
            $this->request->data = $this->InsuranceType->find('first', $options);
        }
        $this->setPhkRequestVar('insurance_type_id', $id);
        $this->setPhkRequestVar('insurance_type_text', $this->request->data['InsuranceType']['name']);
        
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
        $this->InsuranceType->id = $id;
        if (!$this->InsuranceType->exists()) {
            $this->Flash->error(__('Invalid insurance type'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->InsuranceType->delete()) {
            $this->Flash->success(__('Insurance type deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Insurance type can not be deleted'));
        $this->redirect(array('action' => 'view', $id));
    }

    public function beforeRender() {
        parent::beforeRender();
        if (isset($this->viewVars['breadcrumbs'])) {
            return;
        }
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => '', 'text' => __('Insurance Types'), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'insurance_types', 'action' => 'index')), 'text' => __('Insurance Types'), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('insurance_type_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'insurance_types', 'action' => 'index')), 'text' => __('Insurance Types'), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('insurance_type_text'), 'active' => 'active');

                break;
        }
        $headerTitle=__('Insurance Types');
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
