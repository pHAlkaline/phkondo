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
 * FractionInsurances Controller
 *
 * @property Insurance $Insurance
 * @property PaginatorComponent $Paginator
 */
class FractionInsurancesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * Uses
     *
     * @var array
     */
    public $uses = array('Insurance');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings , array(
            'contain' => array('InsuranceType','Fraction'),
            'conditions' => array('Insurance.fraction_id' =>  $this->getPhkRequestVar('fraction_id'))
        ));
        
        $this->setFilter(array('Insurance.title', 'Insurance.insurance_company', 'Insurance.policy', 'InsuranceType.name'));

        $this->set('insurances', $this->Paginator->paginate('Insurance'));
        
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Insurance->exists($id)) {
            $this->Flash->error(__('Invalid insurance'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Insurance->contain(array('InsuranceType','Fraction'));
        $options = array('conditions' => array('Insurance.' . $this->Insurance->primaryKey => $id, 'Insurance.fraction_id' => $this->getPhkRequestVar('fraction_id')));
        $insurance = $this->Insurance->find('first', $options);
        if (!count($insurance)) {
            $this->Flash->success(__('Invalid insurance'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->set('insurance', $insurance);
        
        $this->setPhkRequestVar('insurance_id', $id);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Insurance->create();
            if ($this->Insurance->save($this->request->data)) {
                $this->Flash->success(__('The insurance has been saved'));
                $this->redirect(array('action' => 'view', $this->Insurance->id,'?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The insurance could not be saved. Please, try again.'));
            }
        }
        $condos = $this->Insurance->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $fractions = $this->Insurance->Fraction->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('fraction_id'))));
        $insuranceTypes = $this->Insurance->InsuranceType->find('list', array('conditions' => array('active' => '1')));
        $this->set(compact('condos', 'fractions', 'insuranceTypes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Insurance->exists($id)) {
            $this->Flash->error(__('Invalid insurance'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Insurance->save($this->request->data)) {
                $this->Flash->success(__('The insurance has been saved'));
                $this->redirect(array('action' => 'view', $id,'?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The insurance could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Insurance.' . $this->Insurance->primaryKey => $id));
            $this->request->data = $this->Insurance->find('first', $options);
        }
        $condos = $this->Insurance->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $fractions = $this->Insurance->Fraction->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('fraction_id'))));
        $insuranceTypes = $this->Insurance->InsuranceType->find('list', array('conditions' => array('active' => '1')));
        $this->set(compact('condos', 'fractions', 'insuranceTypes'));
        $this->setPhkRequestVar('insurance_id', $id);
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
        $this->Insurance->id = $id;
        if (!$this->Insurance->exists()) {
           $this->Flash->error(__('Invalid insurance'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        if ($this->Insurance->delete()) {
            $this->Flash->success(__('Insurance deleted'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Flash->error(__('Insurance can not be deleted'));
        $this->redirect(array('action' => 'view', $id,'?'=>$this->request->query));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('condo_id')) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('controller'=>'condos','action' => 'index'));
        }
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index','?'=>array('condo_id'=>$this->getPhkRequestVar('condo_id')))), 'text' => __n('Fraction','Fractions',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'view', $this->getPhkRequestVar('fraction_id'),'?'=>array('condo_id'=>$this->getPhkRequestVar('condo_id')))), 'text' => $this->getPhkRequestVar('fraction_text'), 'active' => ''),
            array('link' => '', 'text' => __n('Insurance','Insurances',2), 'active' => 'active'),
        );

        switch ($this->action) {
            case 'view':
                $breadcrumbs[5] = array('link' => Router::url(array('action' => 'index','?'=>$this->request->query)), 'text' => __n('Insurance','Insurances',2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->getPhkRequestVar('insurance_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[5] = array('link' => Router::url(array('action' => 'index','?'=>$this->request->query)), 'text' => __n('Insurance','Insurances',2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->getPhkRequestVar('insurance_text'), 'active' => 'active');
                break;
        }
        $headerTitle=__n('Insurance','Insurances',2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
