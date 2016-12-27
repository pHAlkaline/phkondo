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
 * @since         pHKondo v 1.4
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */

App::uses('AppController', 'Controller');

/**
 * Suppliers Controller
 *
 * @property Supplier $Supplier
 * @property PaginatorComponent $Paginator
 */
class SuppliersController extends AppController {
    
    public $uses = array ('Supplier','Maintenance','InvoiceConference');

   /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator','Feedback.Comments' => array('on' => array('view')));

     public $helpers = array(
        'Feedback.Comments' => array('elementIndex'=> 'comment_index','elementForm'=> 'comment_add')
        );
        
    /**
     * index method
     *
     * @return void
     */
    public function index() {
       $this->Paginator->settings = array_replace_recursive($this->Paginator->settings ,
                array('conditions' => array()));
        $this->setFilter(array('Supplier.name','Supplier.address','Supplier.email','Supplier.contacts','Supplier.vat_number'));
        $this->set('suppliers', $this->Paginator->paginate('Supplier'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Supplier->exists($id)) {
            $this->Flash->error(__('Invalid supplier'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Supplier->contain(array('Comment'));
        $options = array('conditions' => array('Supplier.' . $this->Supplier->primaryKey => $id));
        $supplier=$this->Supplier->find('first', $options);
        $this->set('supplier',$supplier );
        $this->setPhkRequestVar('supplier_id', $id);
        $this->setPhkRequestVar('supplier_text', $supplier['Supplier']['name']);
        
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Supplier->create();
            if ($this->Supplier->save($this->request->data)) {
                $this->Flash->success(__('The supplier has been saved'));
                $this->redirect(array('action' => 'view',$this->Supplier->id));
            } else {
                $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
            }
        }
        
    }

    

    /**
     * addFromMaintenance method
     *
     * @return void
     */
    public function addFromMaintenance($maintenanceId = null) {
        
        $maintenance = $this->Maintenance;
        if ($maintenanceId != null && !$maintenance->exists($maintenanceId)) {
            $this->Flash->error(__('Invalid supplier'));
            $this->redirect(array('controller'=>'maintenance','action' => 'index','?'=>$this->request->query));
        }
        if ($this->request->is('post')) {
            $this->Supplier->create();
            if ($this->Supplier->save($this->request->data)) {
                $this->Flash->success(__('The supplier has been saved'));
                if ($maintenanceId != null) {
                    $this->redirect(array('controller' => 'maintenances', 'action' => 'edit', $maintenanceId,'?'=>$this->request->query));
                } else {
                    $this->redirect(array('controller' => 'maintenances', 'action' => 'add','?'=>$this->request->query));
                }
            } else {
                $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
            }
        }
        
        $this->set(compact('maintenanceId'));

        if (!$this->getPhkRequestVar('condo_id')) {
            $this->Flash->error(__('Invalid condo'));
           $this->redirect(array('controller'=>'condos','action' => 'index'));
        }

        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'maintenances', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Maintenance','Maintenances',2), 'active' => ''),
            array('link' => '', 'text' => __n('Supplier','Suppliers',2), 'active' => 'active')
        );
        $headerTitle=__n('Supplier','Suppliers',2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

    /**
     * addFromInvoice method
     *
     * @return void
     */
    public function addFromInvoice($invoiceId = null) {
        
        $invoice = $this->InvoiceConference;
        if ($invoiceId != null && !$invoice->exists($invoiceId)) {
            $this->Flash->error(__('Invalid supplier'));
            $this->redirect(array('controller'=>'invoice_conference','action' => 'index','?'=>$this->request->query));
        }
        if ($this->request->is('post')) {
            $this->Supplier->create();
            if ($this->Supplier->save($this->request->data)) {
                $this->Flash->success(__('The supplier has been saved'));
                if ($invoiceId != null) {
                    $this->redirect(array('controller' => 'invoice_conference', 'action' => 'edit', $invoiceId,'?'=>$this->request->query));
                } else {
                    $this->redirect(array('controller' => 'invoice_conference', 'action' => 'add','?'=>$this->request->query));
                }
            } else {
                $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
            }
        }
        
        $this->set(compact('invoiceId'));

        if (!$this->getPhkRequestVar('condo_id')) {
            $this->Flash->error(__('Invalid condo'));
           $this->redirect(array('controller'=>'condos','action' => 'index'));
        }

        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'invoice_conference', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Invoice Conference','Invoice Conferences',2), 'active' => ''),
            array('link' => '', 'text' => __n('Supplier','Suppliers',2), 'active' => 'active')
        );
        $headerTitle=__n('Supplier','Suppliers',2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

    
    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Supplier->exists($id)) {
            $this->Flash->error(__('Invalid supplier'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Supplier->save($this->request->data)) {
                $this->Flash->success(__('The supplier has been saved'));
                $this->redirect(array('action' => 'view',$this->Supplier->id));
            } else {
                $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Supplier.' . $this->Supplier->primaryKey => $id));
            $this->request->data = $this->Supplier->find('first', $options);
        }
        $this->setPhkRequestVar('supplier_id', $id);
        $this->setPhkRequestVar('supplier_text', $this->request->data['Supplier']['name']);
        
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
        $this->Supplier->id = $id;
        if (!$this->Supplier->exists()) {
            $this->Flash->error(__('Invalid supplier'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Supplier->delete()) {
            $this->Flash->success(__('Supplier deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Supplier can not be deleted'));
        $this->redirect(array('action' => 'view',$id));
    }

    public function beforeRender() {
        parent::beforeRender();
        if (isset($this->viewVars['breadcrumbs'])) {
            return;
        }
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => '', 'text' => __n('Supplier','Suppliers',2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'suppliers', 'action' => 'index')), 'text' => __n('Supplier','Suppliers',2), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('supplier_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'suppliers', 'action' => 'index')), 'text' => __n('Supplier','Suppliers',2), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('supplier_text'), 'active' => 'active');
                
                break;
        }
        $headerTitle=__n('Supplier','Suppliers',2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
