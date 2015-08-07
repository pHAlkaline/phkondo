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
 * InvoiceConferences Controller
 *
 * @property InvoiceConference $InvoiceConference
 * @property PaginatorComponent $Paginator
 */
class InvoiceConferenceController extends AppController {

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
        $this->InvoiceConference->contain(array('Supplier'));
        $this->Paginator->settings = $this->paginate;
        $this->Paginator->settings = $this->Paginator->settings + array(
            'conditions' => array(
                'InvoiceConference.condo_id' => $this->Session->read('Condo.ViewID'),
            //'InvoiceConference.fiscal_year_id' => $this->Session->read('Condo.FiscalYearID')
            ),
            'group' => array('supplier_id'),
            'order' => array('Supplier.name' => 'asc'),
            'fields' => array('Supplier.name', 'InvoiceConference.supplier_id')
        );
        $this->setFilter(array('Supplier.name', 'Supplier.email', 'Supplier.vat_number'));


        $invoice = $this->paginate();
        
        $this->InvoiceConference->virtualFields = array('total_amount' => 'SUM(amount)');
        foreach ($invoice as $key => $supplier) {

            $supplierDueAmount = $this->InvoiceConference->field('total_amount', array(
                'InvoiceConference.condo_id' => $this->Session->read('Condo.ViewID'),
                //'InvoiceConference.fiscal_year_id' => $this->Session->read('Condo.FiscalYearID'),
                'InvoiceConference.invoice_conference_status_id <' => '5',
                'InvoiceConference.supplier_id' => $supplier['InvoiceConference']['supplier_id']));
            if ($supplierDueAmount == null) {
                $supplierDueAmount = '0.00';
            }
            $invoice[$key]['InvoiceConference']['total_amount'] = $supplierDueAmount;
        }

        $this->set('invoice', $invoice);
        $this->Session->delete('Condo.InvoiceConference');
    }

    /**
     * index_by_supplier method
     *
     * @return void
     */
    public function index_by_supplier($supplier_id = null) {
        $this->InvoiceConference->contain(array('Supplier','InvoiceConferenceStatus'));
        if (!$this->InvoiceConference->Supplier->exists($supplier_id)) {
            $this->Flash->error(__('Invalid invoice'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Paginator->settings = $this->paginate;
        $this->Paginator->settings = $this->Paginator->settings + array(
            'order' => array('InvoiceConference.document_date' => 'desc'),
            'conditions' => array(
                'InvoiceConference.supplier_id' => $supplier_id,
                'InvoiceConference.condo_id' => $this->Session->read('Condo.ViewID'),
            //'InvoiceConference.fiscal_year_id' => $this->Session->read('Condo.FiscalYearID')
            )
        );
        $this->setFilter(array('InvoiceConference.document_date', 'InvoiceConference.payment_due_date', 'InvoiceConference.document', 'InvoiceConference.description', 'InvoiceConferenceStatus.name'));


        $invoices = $this->paginate();
        $this->set('invoices', $invoices);
        $this->set('supplier_id', $supplier_id);
        if ($this->Session->read('Condo.InvoiceConference.SupplierName') == null) {
            $this->Session->write('Condo.InvoiceConference.SupplierName', $invoices[0]['Supplier']['name']);
            $this->Session->write('Condo.InvoiceConference.SupplierId', $invoices[0]['Supplier']['id']);
        }
        //$this->Session->delete('Condo.InvoiceConference');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->InvoiceConference->contain(array('Supplier','InvoiceConferenceStatus'));
        if (!$this->InvoiceConference->exists($id)) {
            $this->Flash->error(__('Invalid invoice'));
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array(
                'InvoiceConference.' . $this->InvoiceConference->primaryKey => $id,
                'InvoiceConference.condo_id' => $this->Session->read('Condo.ViewID'),
            //'InvoiceConference.fiscal_year_id' => $this->Session->read('Condo.FiscalYearID')
        ));

        $invoice_conference = $this->InvoiceConference->find('first', $options);
        $this->set('invoice_conference', $invoice_conference);
        $this->Session->write('Condo.InvoiceConference.ViewID', $id);
        $this->Session->write('Condo.InvoiceConference.ViewName', $invoice_conference['InvoiceConference']['description'] . ' ( ' . $invoice_conference['InvoiceConference']['document'] . ' ) ');
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($supplier_id = null) {
        if ($supplier_id != null && !$this->InvoiceConference->Supplier->exists($supplier_id)) {
            $this->Flash->error(__('Invalid invoice'));
            $this->redirect(array('action' => 'index'));
        };
        if ($this->request->is('post')) {

            $this->InvoiceConference->create();
            if ($this->InvoiceConference->save($this->request->data)) {
                $this->Flash->success(__('The invoice has been saved'));
                $this->redirect(array('action' => 'view', $this->InvoiceConference->id));
            } else {
                $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
            }
        }

        $condos = $this->InvoiceConference->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $fiscalYears = $this->InvoiceConference->FiscalYear->find('list', array('conditions' => array('id' => $this->Session->read('Condo.FiscalYearID'))));

        $invoiceConferenceStatuses = $this->InvoiceConference->InvoiceConferenceStatus->find('list', array('conditions' => array('active' => '1')));
        $supplier_conditions = array('entity_type_id' => '2');
        if ($supplier_id != null) {
            $supplier_conditions = array('entity_type_id' => '2', 'id' => $supplier_id);
        }

        $suppliers = $this->InvoiceConference->Supplier->find('list', array('order' => 'Supplier.name', 'conditions' => $supplier_conditions));
        $this->set(compact('condos', 'invoiceConferenceStatuses', 'fiscalYears', 'suppliers'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {

        if (!$this->InvoiceConference->exists($id)) {
            $this->Flash->error(__('Invalid invoice'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->InvoiceConference->save($this->request->data)) {
                $this->Flash->success(__('The invoice has been saved'));
                $this->redirect(array('action' => 'index_by_supplier', $this->request->data['InvoiceConference']['supplier_id']));
            } else {
                $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array(
                    'InvoiceConference.' . $this->InvoiceConference->primaryKey => $id,
                    'InvoiceConference.condo_id' => $this->Session->read('Condo.ViewID'),
                //'InvoiceConference.fiscal_year_id' => $this->Session->read('Condo.FiscalYearID'))
            ));
            $this->request->data = $this->InvoiceConference->find('first', $options);
        }
        $condos = $this->InvoiceConference->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $fiscalYears = $this->InvoiceConference->FiscalYear->find('list', array('conditions' => array('condo_id' => $this->request->data['InvoiceConference']['condo_id'])));

        $invoiceConferenceStatuses = $this->InvoiceConference->InvoiceConferenceStatus->find('list', array('conditions' => array('active' => '1')));

        $suppliers = $this->InvoiceConference->Supplier->find('list', array('order' => 'name', 'conditions' => array('entity_type_id' => '2')));
        $this->set(compact('condos', 'invoiceConferenceStatuses', 'fiscalYears', 'suppliers'));
        $this->Session->write('Condo.InvoiceConference.ViewID', $id);
        $this->Session->write('Condo.InvoiceConference.ViewName', $this->request->data['InvoiceConference']['description'] . ' ( ' . $this->request->data['InvoiceConference']['document'] . ' ) ');
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
        $this->InvoiceConference->id = $id;
        if (!$this->InvoiceConference->exists()) {
            $this->Flash->error(__('Invalid invoice'));
            $this->redirect(array('action' => 'index'));
        }

        $this->InvoiceConference->read();
        if ($this->InvoiceConference->delete()) {
            $this->Flash->success(__('Invoice deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Invoice can not be deleted'));
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
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo', 'Condos', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __('Invoice Conference'), 'active' => 'active')
        );

        switch ($this->action) {
            case 'index_by_supplier':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'invoice_conference', 'action' => 'index')), 'text' => __('Invoice Conference'), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->Session->read('Condo.InvoiceConference.SupplierName'), 'active' => 'active');
                break;
            case 'view':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'invoice_conference', 'action' => 'index')), 'text' => __('Invoice Conference'), 'active' => '');
                $breadcrumbs[4] = array('link' => Router::url(array('controller' => 'invoice_conference', 'action' => 'index_by_supplier', $this->Session->read('Condo.InvoiceConference.SupplierId'))), 'text' => $this->Session->read('Condo.InvoiceConference.SupplierName'), 'active' => '');
                $breadcrumbs[5] = array('link' => '', 'text' => $this->Session->read('Condo.InvoiceConference.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'invoice_conference', 'action' => 'index')), 'text' => __('Invoice Conference'), 'active' => '');
                $breadcrumbs[4] = array('link' => Router::url(array('controller' => 'invoice_conference', 'action' => 'index_by_supplier', $this->Session->read('Condo.InvoiceConference.SupplierId'))), 'text' => $this->Session->read('Condo.InvoiceConference.SupplierName'), 'active' => '');
                $breadcrumbs[5] = array('link' => '', 'text' => $this->Session->read('Condo.InvoiceConference.ViewName'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }

}
