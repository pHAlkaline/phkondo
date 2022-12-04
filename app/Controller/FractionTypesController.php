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
 * @since         pHKondo v 1.2.3
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');

/**
 * FractionTypes Controller
 *
 * @property FractionType $FractionType
 * @property PaginatorComponent $Paginator
 */
class FractionTypesController extends AppController {

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
        $this->setFilter(array('FractionType.name'));
       
        $this->set('fractionTypes', $this->Paginator->paginate('FractionType'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->FractionType->exists($id)) {
            $this->Flash->error(__('Invalid fraction type'));
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('FractionType.' . $this->FractionType->primaryKey => $id));
        $fractionType = $this->FractionType->find('first', $options);
        $this->set('fractionType', $fractionType);
        $this->setPhkRequestVar('fraction_type_id', $id);
        $this->setPhkRequestVar('fraction_type_text', $fractionType['FractionType']['name']);
       
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->FractionType->create();
            if ($this->FractionType->save($this->request->data)) {
                $this->Flash->success(__('The fraction type has been saved'));
                $this->redirect(array('action' => 'view', $this->FractionType->id));
            } else {
                $this->Flash->error(__('The fraction type could not be saved. Please, try again.'));
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
        if (!$this->FractionType->exists($id)) {
            $this->Flash->error(__('Invalid fraction types'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->FractionType->save($this->request->data)) {
                $this->Flash->success(__('The fraction type has been saved'));
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Flash->error(__('The fraction type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('FractionType.' . $this->FractionType->primaryKey => $id));
            $this->request->data = $this->FractionType->find('first', $options);
        }
        $this->setPhkRequestVar('fraction_type_id', $id);
        $this->setPhkRequestVar('fraction_type_text', $this->request->data['FractionType']['name']);
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
        $this->FractionType->id = $id;
        if (!$this->FractionType->exists()) {
            $this->Flash->error(__('Invalid fraction type'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->FractionType->delete()) {
            $this->Flash->success(__('Fraction type deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Fraction type can not be deleted'));
        $this->redirect(array('action' => 'view', $id));
    }

    public function beforeRender() {
        parent::beforeRender();
        if (isset($this->viewVars['breadcrumbs'])) {
            return;
        }
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'fraction_types', 'action' => 'index', '?' => $this->request->query), true), 'text' => __('Fraction Types'), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[0] = array('link' => Router::url(array('controller' => 'fraction_types', 'action' => 'index')), 'text' => __('Fraction Types'), 'active' => '');
                $breadcrumbs[1] = array('link' => '', 'text' => $this->getPhkRequestVar('fraction_type_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[0] = array('link' => Router::url(array('controller' => 'fraction_types', 'action' => 'index')), 'text' => __('Fraction Types'), 'active' => '');
                $breadcrumbs[1] = array('link' => '', 'text' => $this->getPhkRequestVar('fraction_type_text'), 'active' => 'active');

                break;
        }
        $headerTitle=__('Fraction Types');
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
