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
 * Maintenances Controller
 *
 * @property Maintenance $Maintenance
 * @property PaginatorComponent $Paginator
 */
class MaintenancesController extends AppController {

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
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings , array(
            'contain' => array ('Supplier'),
            'conditions' => array('Maintenance.condo_id' => $this->getPhkRequestVar('condo_id'))
        ));
        $this->setFilter(array('Maintenance.title','Maintenance.client_number', 'Supplier.name'));
        
        $this->set('maintenances', $this->Paginator->paginate('Maintenance'));
        
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Maintenance->contain('Supplier');
        if (!$this->Maintenance->exists($id)) {
            $this->Flash->error(__('Invalid maintenance'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $options = array('conditions' => array('Maintenance.' . $this->Maintenance->primaryKey => $id));
        $maintenance=$this->Maintenance->find('first', $options);
        if (!count($maintenance)){
            $this->Flash->error(__('Invalid maintenance'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->set('maintenance', $maintenance);
        $this->setPhkRequestVar('maintenance_id',$id);
        
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Maintenance->create();
            if ($this->Maintenance->save($this->request->data)) {
                $this->Flash->success(__('The maintenance has been saved'));
                $this->redirect(array('action' => 'view',$this->Maintenance->id,'?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The maintenance could not be saved. Please, try again.'));
            }
        }
        $condos = $this->Maintenance->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $suppliers = $this->Maintenance->Supplier->find('list', array('order'=>'Supplier.name'));
        $this->set(compact('condos', 'suppliers'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Maintenance->exists($id)) {
            $this->Flash->error(__('Invalid maintenance'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Maintenance->save($this->request->data)) {
                $this->Flash->success(__('The maintenance has been saved'));
                $this->redirect(array('action' => 'view',$id,'?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The maintenance could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Maintenance.' . $this->Maintenance->primaryKey => $id));
            $this->request->data = $this->Maintenance->find('first', $options);
        }
        $condos = $this->Maintenance->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $suppliers = $this->Maintenance->Supplier->find('list', array('order'=>'name'));
        $this->set(compact('condos', 'suppliers'));
        $this->setPhkRequestVar('maintenance_id',$id);
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
        $this->Maintenance->id = $id;
        if (!$this->Maintenance->exists()) {
            $this->Flash->error(__('Invalid maintenance'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        if ($this->Maintenance->delete()) {
            $this->Flash->success(__('Maintenance deleted'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Flash->error(__('Maintenance can not be deleted'));
        $this->redirect(array('action' => 'view',$id,'?'=>$this->request->query));
    }

    
    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('condo_id')) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('controller' => 'condos', 'action' => 'index'));
        }
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo', 'Condos', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view',$this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => '', 'text' => __n('Maintenance','Maintenances',2), 'active' => 'active')
        );
       switch ($this->action) {
            case 'view':
                 $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'maintenances', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Maintenance','Maintenances',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('maintenance_text'), 'active' => 'active');
                break;
            case 'edit':
                   $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'maintenances', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Maintenance','Maintenances',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('maintenance_text'), 'active' => 'active');
               
                break;
        }
        $headerTitle=__n('Maintenance','Maintenances',2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
