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
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');
App::uses('CakeEvent', 'Event');

/**
 * OwnerReceipts Controller
 *
 * @property Receipt $Receipt
 * @property PaginatorComponent $Paginator
 */
class OwnerReceiptsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'RequestHandler');

    /**
     * Uses
     *
     * @var array
     */
    public $uses = array('Receipt');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Receipt->contain('Entity', 'ReceiptStatus', 'ReceiptPaymentType');
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings, array(
            'contain' => array('Entity', 'ReceiptStatus', 'ReceiptPaymentType'),
            'conditions' => array(
                'Receipt.entity_id' => $this->getPhkRequestVar('owner_id'),
                'Receipt.fraction_id' => $this->getPhkRequestVar('fraction_id')
            )
        ));
        $this->setFilter(array('Receipt.document', 'Entity.name', 'ReceiptStatus.name', 'ReceiptPaymentType.name', 'Receipt.total_amount'));

        $this->set('receipts', $this->Paginator->paginate('Receipt'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $this->Receipt->contain(array(
            'Fraction',
            'Entity',
            'ReceiptStatus',
            'ReceiptPaymentType',
            'ReceiptNote' => array('NoteType', 'Fraction'),
            'Note' => array('NoteType', 'Fraction')
        ));
        $options = array('conditions' => array('Receipt.id' => $id, 'Receipt.entity_id' => $this->getPhkRequestVar('owner_id'), 'Receipt.fraction_id' => $this->getPhkRequestVar('fraction_id')));
        $receipt = $this->Receipt->find('first', $options);
        $this->Receipt->Entity->order = 'Entity.name';
        $notificationEntities = $this->Receipt->Entity->find('list', array('fields' => array('Entity.email', 'Entity.email'), 'conditions' => array('id' => $receipt['Entity']['id'])));

        $emailNotifications = Configure::read('EmailNotifications');

        $this->set(compact('receipt', 'notificationEntities', 'emailNotifications'));
        $this->setPhkRequestVar('receipt_id', $id);
        $this->setPhkRequestVar('receipt_view', $receipt['Receipt']['document']);
    }

    /**
     * print_receipt method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function print_receipt($id)
    {
        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }

        $event = new CakeEvent('Phkondo.Receipt.print', $this, array(
            'id' => $id,
        ));
        $this->getEventManager()->dispatch($event);
    }

    /**
     * send_owner_receipt method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function send_owner_receipt($id)
    {
        if (Configure::read('Application.stage') == 'demo') {
            $this->Flash->success(__d('email', 'Email sent with success.'));
            $this->Flash->warning(__d('email', 'In Demo Sessions this feature is disbled to avoid spam!!.'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }
        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }

        $event = new CakeEvent('Phkondo.Receipt.send_owner_receipt', $this, array(
            'id' => $id,
        ));
        $this->getEventManager()->dispatch($event);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Receipt->create();
            $this->Receipt->Entity->id = $this->request->data['Receipt']['entity_id'];
            $this->Receipt->Entity->order = 'Entity.name';
            $this->request->data['Receipt']['address'] = $this->Receipt->Entity->field('address');
            
            $this->request->data['Receipt']['document'] = $this->getPhkRequestVar('condo_id') . Date('Y') . '-' . sprintf('%06d', $number);
            if ($this->request->data['Receipt']['document_date'] == '') {
                $this->request->data['Receipt']['document_date'] = date(Configure::read('Application.dateFormatSimple'));
            }

            if ($this->Receipt->save($this->request->data)) {
                $this->Flash->success(__('The receipt has been saved'));
                $this->redirect(array('action' => 'edit', $this->Receipt->id, '?' => $this->request->query, '#' => 'AddNotes'));
            } else {
                //debug($this->Receipt->validationErrors);
                //debug($this->request->data);
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        }
        $condos = $this->Receipt->Condo->find('list', array('conditions' => array('Condo.id' => $this->getPhkRequestVar('condo_id'))));
        $entities = $this->Receipt->Entity->find('list', array('order' => 'Entity.name', 'conditions' => array('Entity.id' => $this->getPhkRequestVar('owner_id'))));
        $fractions = $this->Receipt->Fraction->find('list', array('conditions' => array('Fraction.id' => $this->getPhkRequestVar('fraction_id'))));
        $receiptStatuses = $this->Receipt->ReceiptStatus->find('list', array('conditions' => array('id' => array('1', '2'), 'active' => '1')));
        $receiptPaymentTypes = $this->Receipt->ReceiptPaymentType->find('list', array('conditions' => array('active' => '1')));
        $this->set(compact('condos', 'fractions', 'entities', 'receiptStatuses', 'receiptPaymentTypes'));
    }

    /**
     * add_notes method
     *
     * @return void
     */
    public function add_notes($id)
    {
        if (!$this->Receipt->editable($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }

        if ($this->request->is('post') && isset($this->request->data['Note'])) {

            $this->Receipt->Note->updateAll(
                array(
                    'Note.receipt_id' => null,
                    'Note.pending_amount' => 0
                ),
                array(
                    'Note.fraction_id' => $this->getPhkRequestVar('fraction_id'),
                    'Note.entity_id' => $this->Receipt->field('entity_id'),
                    'Note.note_status_id' => array(1, 2),
                    'Note.receipt_id' => $id
                )
            );
            $this->Receipt->setReceiptAmount($id);
            foreach ($this->request->data['Note'] as $key => $note) {

                if (isset($note['check'])) {

                    $noteOk = $this->Receipt->Note->find('count', array('conditions' => array('Note.id' => $key, 'Note.receipt_id' => null)));

                    if ($noteOk == 0) {
                        $this->Flash->error(__('The notes could not be saved. Please, try again.'));
                        $this->redirect(array('action' => 'edit', $id, '?' => $this->request->query, '#' => 'AddNotes'));
                        return;
                    }
                    $this->Receipt->Note->id = $key;
                    $this->Receipt->Note->saveField('receipt_id', $id, array('callbacks' => false));
                    $this->Receipt->Note->saveField('pending_amount', '0', array('callbacks' => false));
                }
            }
            $this->Receipt->setReceiptAmount($id);
            //$this->redirect(array('action' => 'edit', $id, '?' => $this->request->query, '#' => 'AddNotes'));
        }
        $this->redirect(array('action' => 'edit', $id, '?' => $this->request->query, '#' => 'AddNotes'));
    
    }

  
    /**
     * pay_receipt method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function pay_receipt($id = null)
    {

        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }


        if (!$this->Receipt->payable($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }

        if (!empty($this->request->data) && ($this->request->is('post') || $this->request->is('put'))) {
            $this->request->data['Receipt']['payment_user_id']=AuthComponent::user('id');
            if ($this->Receipt->saveAssociated($this->request->data)) {
                $this->Flash->success(__('The receipt has been saved'));
                $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
            } else {
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Receipt.' . $this->Receipt->primaryKey => $id, 'OR' => array('Receipt.receipt_status_id' => array('2'))));
            $this->request->data = $this->Receipt->find('first', $options);
            if (empty($this->request->data)) {
                $this->Flash->error(__('Invalid receipt'));
                $this->redirect(array('action' => 'index', '?' => $this->request->query));
            }
        }
        $condos = $this->Receipt->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $fractions = $this->Receipt->Fraction->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('fraction_id'))));
        $entities = $this->Receipt->Entity->find('list', array('order' => 'Entity.name', 'conditions' => array('id' => $this->getPhkRequestVar('owner_id'))));
        $receiptStatuses = $this->Receipt->ReceiptStatus->find('list', array('conditions' => array('id' => array('3'), 'active' => '1')));
        $receiptPaymentTypes = $this->Receipt->ReceiptPaymentType->find('list', array('conditions' => array('active' => '1')));

        $notes = $this->Receipt->Note->find(
            'all',
            array(
                'contain' => array('NoteType', 'Fraction'),
                'conditions' => array(
                    'Note.receipt_id' => $id,
                    'Note.fraction_id' => $this->getPhkRequestVar('fraction_id'),
                    'Note.entity_id' => $this->request->data['Receipt']['entity_id'],
                )
            )
        );
        $this->set(compact('condos', 'fractions', 'entities', 'receiptStatuses', 'receiptPaymentTypes', 'notes'));

        $fiscalYears = $this->Receipt->Movement->FiscalYear->find('list', array('conditions' => array('active' => '1', 'condo_id' => $this->getPhkRequestVar('condo_id'), 'id' => $this->getPhkRequestVar('fiscal_year_id'))));
        $fiscalYearData = $this->Receipt->Movement->FiscalYear->find('first', array('fields' => array('open_date', 'close_date'), 'conditions' => array('active' => '1', 'condo_id' => $this->getPhkRequestVar('condo_id'), 'id' => $this->getPhkRequestVar('fiscal_year_id'))));
        $accounts = $this->Receipt->Movement->Account->find('list', array('conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));
        foreach ($accounts as $idx => $account) {
            $closeMovement = $this->Receipt->Movement->find('count', array(
                'conditions' =>
                array(
                    'Movement.fiscal_year_id' => $this->getPhkRequestVar('fiscal_year_id'),
                    'Movement.account_id' => $idx,
                    'Movement.movement_operation_id' => '2'
                ),
            ));
            if ($closeMovement) {
                unset($accounts[$idx]);
            }
        }
        $movementTypes = $this->Receipt->Movement->MovementType->find('list', array('conditions' => array('active' => '1','id'=>1)));
        $movementCategories = $this->Receipt->Movement->MovementCategory->find('list', array('conditions' => array('active' => '1')));
        $movementOperations = $this->Receipt->Movement->MovementOperation->find('list', array('conditions' => array('MovementOperation.id NOT IN' => [1, 2, 3], 'active' => '1')));
        $this->set(compact('accounts', 'fiscalYears', 'fiscalYearData', 'movementTypes', 'movementCategories', 'movementOperations'));


        $this->setPhkRequestVar('receipt_id', $id);
        $this->setPhkRequestVar('receipt_text', $this->request->data['Receipt']['document']);
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }

        if (!$this->Receipt->editable($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Receipt->save($this->request->data)) {
                $this->Flash->success(__('The receipt has been saved'));
                $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
            } else {
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array(
                'Receipt.' . $this->Receipt->primaryKey => $id,
                'Receipt.entity_id' => $this->getPhkRequestVar('owner_id'),
                'Receipt.fraction_id' => $this->getPhkRequestVar('fraction_id'),
                'AND' => array(
                    'Receipt.receipt_status_id' => array('1', '2')
                )
            ));
            $this->Receipt->contain(array('Note' => array('NoteType', 'Fraction')));
            $receipt = $this->Receipt->find('first', $options);
            $this->request->data = $receipt;
            $this->set(compact('receipt'));

            if (empty($this->request->data)) {
                $this->Flash->error(__('Invalid receipt'));
                $this->redirect(array('action' => 'index', '?' => $this->request->query));
            }
        }



        $condos = $this->Receipt->Condo->find('list', array('conditions' => array('id' => $this->request->data['Receipt']['condo_id'])));
        $fractions = $this->Receipt->Fraction->find('list', array('conditions' => array('Fraction.id' => $this->request->data['Receipt']['fraction_id'])));
        $entities = $this->Receipt->Entity->find('list', array('order' => 'Entity.name', 'conditions' => array('id' => $this->request->data['Receipt']['entity_id'])));
        $receiptStatuses = $this->Receipt->ReceiptStatus->find('list', array('conditions' => array('id' => array('1', '2'), 'active' => '1')));
        $receiptPaymentTypes = $this->Receipt->ReceiptPaymentType->find('list', array('conditions' => array('active' => '1')));

        $this->Receipt->Note->contain(array('NoteType', 'Entity', 'Fraction'));
        $notes = $this->Receipt->Note->find(
            'all',
            array(
                'conditions' => array(
                    'OR' => array('Note.receipt_id IS NULL', 'Note.receipt_id' => $id),
                    'AND' => array(
                        'Note.fraction_id' => $this->getPhkRequestVar('fraction_id'),
                        'Note.entity_id' => $this->Receipt->field('entity_id'),
                        'Note.note_status_id' => array(1, 2)
                    ),
                )
            )
        );
        $receiptAmount = 0; //$this->Receipt->field('total_amount');
        $receiptId = $this->Receipt->field('document');
        $this->set(compact('notes', 'receiptAmount', 'receiptId', 'id'));
        $this->set(compact('condos', 'fractions', 'entities', 'receiptStatuses', 'receiptPaymentTypes'));

        $this->setPhkRequestVar('receipt_id', $id);
        $this->setPhkRequestVar('receipt_text', $this->request->data['Receipt']['document']);
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index'));
        }


        if (!$this->Receipt->deletable($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }
        
        if ($this->Receipt->delete()) {

            $this->Flash->success(__('Receipt deleted'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $this->Flash->error(__('Receipt can not be deleted'));
        $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
    }

   
    /**
     * cancel method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function cancel($id = null)
    {
        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }


        if (!$this->Receipt->cancelable($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }

        if (!empty($this->request->data) && ($this->request->is('post') || $this->request->is('put'))) {
            $this->request->data['Receipt']['cancel_user_id']=AuthComponent::user('id');
            if ($this->Receipt->save($this->request->data)) {
                $this->Flash->success(__('The receipt has been saved'));
                $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
            } else {
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Receipt.id' => $id));
            $this->request->data = $this->Receipt->find('first', $options);
            if (empty($this->request->data)) {
                $this->Flash->error(__('Invalid receipt'));
                $this->redirect(array('action' => 'index', '?' => $this->request->query));
            }
        }

        $condos = $this->Receipt->Condo->find('list', array('conditions' => array('id' => $this->request->data['Receipt']['condo_id'])));
        $fractions = $this->Receipt->Fraction->find('list', array('conditions' => array('id' => $this->request->data['Receipt']['fraction_id'])));
        $entities = $this->Receipt->Entity->find('list', array('order' => 'Entity.name', 'conditions' => array('id' => $this->request->data['Receipt']['entity_id'])));
        $receiptStatuses = $this->Receipt->ReceiptStatus->find('list', array('conditions' => array('id' => array('4'), 'active' => '1')));
        $receiptPaymentTypes = $this->Receipt->ReceiptPaymentType->find('list', array('conditions' => array('active' => '1')));
        $notes = $this->Receipt->Note->find(
            'all',
            array(
                'contain' => array('NoteType', 'Fraction'),
                'conditions' => array(
                    'Note.receipt_id' => $id,
                    'Note.fraction_id' => $this->getPhkRequestVar('fraction_id'),
                    'Note.entity_id' => $this->request->data['Receipt']['entity_id'],
                )
            )
        );

        $this->set(compact('condos', 'fractions', 'entities', 'receiptStatuses', 'receiptPaymentTypes', 'notes'));

        $this->setPhkRequestVar('receipt_id', $id);
        $this->setPhkRequestVar('receipt_text', $this->request->data['Receipt']['document']);
    }

    
    public function beforeFilter()
    {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('fraction_id')) {
            $this->Flash->error(__('Invalid fraction'));
            $this->redirect(array('controller' => 'condos', 'action' => 'index'));
        }
    }

    public function beforeRender()
    {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text') . ' ( ' . $this->phkRequestData['fiscal_year_text'] . ' ) ', 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index', '?' => array('condo_id' => $this->getPhkRequestVar('condo_id')))), 'text' => __n('Fraction', 'Fractions', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'view', $this->getPhkRequestVar('fraction_id'), '?' => array('condo_id' => $this->getPhkRequestVar('condo_id')))), 'text' => $this->getPhkRequestVar('fraction_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fraction_owners', 'action' => 'index', '?' => array('fraction_id' => $this->getPhkRequestVar('fraction_id')))), 'text' => __n('Owner', 'Owners', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fraction_owners', 'action' => 'view', $this->getPhkRequestVar('owner_id'), '?' => array('fraction_id' => $this->getPhkRequestVar('fraction_id')))), 'text' => $this->getPhkRequestVar('owner_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'owner_receipts', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Receipt', 'Receipts', 2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'add_notes':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'owner_receipts', 'action' => 'index', '?' => array('owner_id' => $this->getPhkRequestVar('owner_id'), 'fraction_id' => $this->getPhkRequestVar('fraction_id')))), 'text' => __n('Receipt', 'Receipts', 2), 'active' => '');
                $breadcrumbs[6] = array('link' => Router::url(array('controller' => 'owner_receipts', 'action' => 'view', $this->getPhkRequestVar('receipt_id'))), 'text' => $this->getPhkRequestVar('receipt_text'), 'active' => '');
                $breadcrumbs[7] = array('link' => '', 'text' => __('Pick Notes'), 'active' => 'active');
                break;
            case 'view':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'owner_receipts', 'action' => 'index', '?' => array('owner_id' => $this->getPhkRequestVar('owner_id'), 'fraction_id' => $this->getPhkRequestVar('fraction_id')))), 'text' => __n('Receipt', 'Receipts', 2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->getPhkRequestVar('receipt_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'owner_receipts', 'action' => 'index', '?' => array('owner_id' => $this->getPhkRequestVar('owner_id'), 'fraction_id' => $this->getPhkRequestVar('fraction_id')))), 'text' => __n('Receipt', 'Receipts', 2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->getPhkRequestVar('receipt_text'), 'active' => 'active');
                break;
            case 'cancel':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'owner_receipts', 'action' => 'index', '?' => array('owner_id' => $this->getPhkRequestVar('owner_id'), 'fraction_id' => $this->getPhkRequestVar('fraction_id')))), 'text' => __n('Receipt', 'Receipts', 2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->getPhkRequestVar('receipt_text'), 'active' => 'active');
                break;
            case 'pay_receipt':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'owner_receipts', 'action' => 'index', '?' => array('owner_id' => $this->getPhkRequestVar('owner_id'), 'fraction_id' => $this->getPhkRequestVar('fraction_id')))), 'text' => __n('Receipt', 'Receipts', 2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->getPhkRequestVar('receipt_text'), 'active' => 'active');
                break;
        }
        $headerTitle = __n('Receipt', 'Receipts', 2);
        $this->set(compact('breadcrumbs', 'headerTitle'));
    }
}
