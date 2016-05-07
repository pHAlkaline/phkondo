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
App::uses('CakeEvent', 'Event');

/**
 * Receipts Controller
 *
 * @property Receipt $Receipt
 * @property PaginatorComponent $Paginator
 */
class ReceiptsController extends AppController {

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
    public function index() {
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings , array(
            'contain' => array('Fraction', 'Client', 'ReceiptStatus', 'ReceiptPaymentType'),
            'conditions' => array(
                'Receipt.condo_id' => $this->getPhkRequestVar('condo_id'),
            ),
        ));
        $this->setFilter(array('Receipt.document', 'Client.name', 'ReceiptStatus.name', 'ReceiptPaymentType.name', 'Receipt.total_amount'));
        $this->set('receipts', $this->Paginator->paginate('Receipt'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $this->Receipt->contain(array(
            'Fraction',
            'Client',
            'ReceiptStatus',
            'ReceiptPaymentType',
            'ReceiptNote' => array('NoteType', 'Fraction'),
            'Note' => array('NoteType', 'Fraction')
        ));
        $options = array('conditions' => array('Receipt.' . $this->Receipt->primaryKey => $id, 'Receipt.condo_id' => $this->getPhkRequestVar('condo_id')));
        $receipt = $this->Receipt->find('first', $options);
        $this->set(compact('receipt'));
        $this->setPhkRequestVar('receipt_id', $id);
    }

    /**
     * print_receipt method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function print_receipt($id) {
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
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post') && isset($this->request->data['Receipt']['change_filter']) && $this->request->data['Receipt']['change_filter'] != '1') {
            $this->Receipt->create();
            $this->Receipt->Client->id = $this->request->data['Receipt']['client_id'];
            $this->Receipt->Client->order = 'Client.name';
            $this->request->data['Receipt']['address'] = $this->Receipt->Client->field('address');
            $number = $this->_getNextReceiptIndex($this->getPhkRequestVar('condo_id'));
            $this->request->data['Receipt']['document'] = $this->getPhkRequestVar('condo_id') . Date('Y') . '-' . sprintf('%06d', $number);
            $this->request->data['Receipt']['document_date'] = date(Configure::read('dateFormatSimple'));
            if ($this->Receipt->save($this->request->data)) {
                $this->_setReceiptIndex($this->getPhkRequestVar('condo_id'), $number);
                $this->Flash->success(__('The receipt has been saved'));
                $this->redirect(array('action' => 'edit', $this->Receipt->id, '?' => $this->request->query));
            } else {
                //debug($this->Receipt->validationErrors);
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        }
        $condos = $this->Receipt->Condo->find('list', array('conditions' => array('Condo.id' => $this->getPhkRequestVar('condo_id'))));
        $fractions = $this->Receipt->Condo->Fraction->find('list', array('conditions' => array('Fraction.condo_id' => $this->getPhkRequestVar('condo_id'))));

        If (!isset($this->request->data['Receipt']['fraction_id'])) {
            $fractionsForClients = $fractions;
            reset($fractionsForClients);
            $firstFraction = key($fractionsForClients);
        } else {
            $firstFraction = $this->request->data['Receipt']['fraction_id'];
        }
        $this->Receipt->Fraction->contain('Entity');
        $fractionsForClients = $this->Receipt->Fraction->find('all', array('conditions' => array('Fraction.id' => $firstFraction)));
        $clients = $this->Receipt->Client->find('list', array('order' => 'Client.name', 'conditions' => array('Client.id' => Set::extract('/Entity/id', $fractionsForClients))));
        $receiptStatuses = $this->Receipt->ReceiptStatus->find('list', array('conditions' => array('id' => array('1', '2'), 'active' => '1')));
        $receiptPaymentTypes = $this->Receipt->ReceiptPaymentType->find('list', array('conditions' => array('active' => '1')));
        unset($this->request->data['Receipt']['change_filter']);
        $this->set(compact('condos', 'fractions', 'clients', 'receiptStatuses', 'receiptPaymentTypes'));
    }

    /**
     * add_notes method
     *
     * @return void
     */
    public function add_notes($id) {

        if (!$this->Receipt->editable($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', $id, '?' => $this->request->query));
        }

        if ($this->request->is('post') && isset($this->request->data['Note'])) {
            $this->Receipt->Note->updateAll(
                    array(
                'Note.receipt_id' => null,
                'Note.pending_amount' => 0
                    ), array(
                'Note.fraction_id' => $this->request->data['Fraction']['id'],
                'Note.entity_id' => $this->Receipt->field('client_id'),
                'Note.note_status_id' => array(1, 2),
                'Note.receipt_id' => $id)
            );
            $this->_setReceiptAmount($id);
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
            $this->_setReceiptAmount($id);
            //$this->redirect(array('action' => 'edit', $id, '#' => 'AddNotes'));
        }
        $this->redirect(array('action' => 'edit', $id, '?' => $this->request->query, '#' => 'AddNotes'));
        /* $this->Receipt->Note->contain(array('NoteType', 'Entity', 'Fraction'));
          $notes = $this->Receipt->Note->find('all', array('conditions' => array('Note.fraction_id' => $this->request->data['Fraction']['id'], 'Note.entity_id' => $this->Receipt->field('client_id'), 'Note.note_status_id' => array(1, 2), 'Note.receipt_id' => '')));

          $receiptAmount = $this->Receipt->field('total_amount');
          $receiptId = $this->Receipt->field('document');
          $this->set(compact('notes', 'receiptAmount', 'receiptId', 'id')); */
    }

    /**
     * remove_note method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    /* public function remove_note($id = null) {
      if (!$this->Receipt->Note->exists($id)) {
      $this->Flash->error(__('Invalid note'));
      $this->redirect(array('action' => 'index'));
      }
      $this->Receipt->Note->id = $id;
      $receipt = $this->Receipt->Note->field('receipt_id');
      if ($receipt != $this->getPhkRequestVar('receipt_id')) {
      $this->Flash->error(__('Invalid note'));
      $this->redirect(array('action' => 'edit', $receipt));
      }
      $this->Receipt->Note->id = $id;
      $this->Receipt->Note->saveField('receipt_id', null, array('callbacks' => false));
      $restoreAmount = $this->Receipt->Note->field('amount');
      $this->Receipt->Note->saveField('pending_amount', $restoreAmount, array('callbacks' => false));
      $this->_setReceiptAmount($receipt);
      $this->redirect(array('action' => 'edit', $receipt));
      } */

    /**
     * pay receipt method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function pay_receipt($id = null) {

        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }

        if (!$this->Receipt->payable($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }

        if (!empty($this->request->data) && ($this->request->is('post') || $this->request->is('put'))) {
            if ($this->Receipt->save($this->request->data)) {
                $this->close($id);
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
        $clients = $this->Receipt->Client->find('list', array('order' => 'Client.name', 'conditions' => array('id' => $this->request->data['Receipt']['client_id'])));
        $fractions = $this->Receipt->Fraction->find('list', array('conditions' => array('id' => $this->request->data['Receipt']['fraction_id'])));
        $receiptStatuses = $this->Receipt->ReceiptStatus->find('list', array('conditions' => array('id' => array('3'), 'active' => '1')));
        $receiptPaymentTypes = $this->Receipt->ReceiptPaymentType->find('list', array('conditions' => array('active' => '1')));
        $notes = $this->Receipt->Note->find('all', array(
            'contain' => array('NoteType', 'Fraction'),
            'conditions' => array(
                'Note.receipt_id' => $id,
                'Note.fraction_id' => $this->request->data['Receipt']['fraction_id'],
                'Note.entity_id' => $this->request->data['Receipt']['client_id'],
            ))
        );
        $this->set(compact('condos', 'fractions', 'clients', 'receiptStatuses', 'receiptPaymentTypes', 'notes'));
        $this->setPhkRequestVar('receipt_id', $id);
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
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
                    'OR' => array('Receipt.receipt_status_id' => array('1', '2'))));
            $this->Receipt->contain(array('Note' => array('NoteType', 'Fraction')));

            $this->request->data = $this->Receipt->find('first', $options);
            if (empty($this->request->data)) {
                $this->Flash->error(__('Invalid receipt'));
                $this->redirect(array('action' => 'index', '?' => $this->request->query));
            }
        }

        $condos = $this->Receipt->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $fractions = $this->Receipt->Fraction->find('list', array('conditions' => array('Fraction.id' => $this->request->data['Receipt']['fraction_id'])));
        $clients = $this->Receipt->Client->find('list', array('order' => 'Client.name', 'conditions' => array('id' => $this->request->data['Receipt']['client_id'])));
        $receiptStatuses = $this->Receipt->ReceiptStatus->find('list', array('conditions' => array('id' => array('1', '2'), 'active' => '1')));
        $receiptPaymentTypes = $this->Receipt->ReceiptPaymentType->find('list', array('conditions' => array('active' => '1')));

        $this->Receipt->Note->contain(array('NoteType', 'Entity', 'Fraction'));
        $notes = $this->Receipt->Note->find('all', array(
            'conditions' => array(
                'OR' => array('Note.receipt_id IS NULL', 'Note.receipt_id' => $id),
                'AND' => array(
                    'Note.fraction_id' => $this->Receipt->field('fraction_id'),
                    'Note.entity_id' => $this->Receipt->field('client_id'),
                    'Note.note_status_id' => array(1, 2)),
            ))
        );
        $receiptAmount = 0; //$this->Receipt->field('total_amount');
        $receiptId = $this->Receipt->field('document');
        $this->set(compact('notes', 'receiptAmount', 'receiptId', 'id'));

        $this->set(compact('condos', 'fractions', 'clients', 'receiptStatuses', 'receiptPaymentTypes'));

        $this->setPhkRequestVar('receipt_id', $id);
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
        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }


        if (!$this->Receipt->deletable($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }
        $this->_removeFromNote($id);
        if ($this->Receipt->delete()) {

            $this->Flash->success(__('Receipt deleted'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $this->Flash->error(__('Receipt can not be deleted'));
        $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
    }

    /**
     * close method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function close($id = null) {
        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }


        if (!$this->Receipt->closeable()) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }

        $this->Receipt->saveField('payment_user_id', AuthComponent::user('id'));
        $this->_setNotesStatus($id);
        $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
    }

    /**
     * cancel method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function cancel($id = null) {
        if (!$this->Receipt->exists($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }


        if (!$this->Receipt->cancelable($id)) {
            $this->Flash->error(__('Invalid receipt'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }

        if (!empty($this->request->data) && ($this->request->is('post') || $this->request->is('put'))) {
            if ($this->Receipt->save($this->request->data)) {
                $this->Receipt->saveField('cancel_user_id', AuthComponent::user('id'));
                $this->_transferNotes($id);
                $this->_removeFromNote($id);
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
        $clients = $this->Receipt->Client->find('list', array('order' => 'Client.name', 'conditions' => array('id' => $this->request->data['Receipt']['client_id'])));
        $receiptStatuses = $this->Receipt->ReceiptStatus->find('list', array('conditions' => array('id' => array('4'), 'active' => '1')));
        $receiptPaymentTypes = $this->Receipt->ReceiptPaymentType->find('list', array('conditions' => array('active' => '1')));
        $notes = $this->Receipt->Note->find('all', array(
            'contain' => array('NoteType', 'Fraction'),
            'conditions' => array(
                'Note.receipt_id' => $id,
                'Note.fraction_id' => $this->request->data['Receipt']['fraction_id'],
                'Note.entity_id' => $this->request->data['Receipt']['client_id'],
            ))
        );
        $this->set(compact('condos', 'fractions', 'clients', 'receiptStatuses', 'receiptPaymentTypes', 'notes'));
        $this->setPhkRequestVar('receipt_id', $id);
    }

    private function _transferNotes($id) {
        $options = array('conditions' => array('Note.receipt_id' => $id));
        $notes = $this->Receipt->Note->find('all', $options);
        if (count($notes) == 0) {
            return true;
        }
        foreach ($notes as $key => $note) {
            unset($notes[$key]['Note']['id']);
            $notes[$key]['Note']['note_status_id'] = 4;
            $receiptNotes[]['ReceiptNote'] = $notes[$key]['Note'];
        }
        if ($this->Receipt->ReceiptNote->saveAll($receiptNotes)) {
            return true;
        }
        return false;
    }

    private function _removeFromNote($id) {
        return $this->Receipt->Note->updateAll(array('Note.receipt_id' => null, 'Note.note_status_id' => '1', 'Note.pending_amount' => 'Note.amount', 'Note.payment_date' => null), array('Note.receipt_id' => $id));
    }

    private function _setNotesStatus($id) {
        return $this->Receipt->Note->updateAll(array('Note.note_status_id' => '3', 'Note.pending_amount' => '0', 'Note.payment_date' => 'Receipt.payment_date'), array('Note.receipt_id' => $id));
    }

    private function _setReceiptAmount($id) {
        $totalDebit = $this->Receipt->Note->find('first', array('fields' =>
            array('SUM(Note.amount) AS total'),
            'conditions' => array('Note.receipt_id' => $id, 'Note.note_type_id' => '2')
                )
        );
        $totalCredit = $this->Receipt->Note->find('first', array('fields' =>
            array('SUM(Note.amount) AS total'),
            'conditions' => array('Note.receipt_id' => $id, 'Note.note_type_id' => '1')
                )
        );
        $total = $totalDebit[0]['total'] - $totalCredit[0]['total'];
        $this->Receipt->id = $id;
        $this->Receipt->saveField('total_amount', $total);
    }

    private function _getNextReceiptIndex($id) {
        $this->loadModel("ReceiptCounters");
        $index = $this->ReceiptCounters->find('first', array('conditions' => array('condo_id' => $id)));

        if (!isset($index['ReceiptCounters']['counter'])) {
            $this->ReceiptCounters->create();
            $this->ReceiptCounters->save(array('ReceiptCounters' => array('condo_id' => $id, 'counter' => 1)));
            return $index = 1;
        }

        return $index['ReceiptCounters']['counter'] + 1;
    }

    private function _setReceiptIndex($condo_id, $index) {
        $this->loadModel("ReceiptCounters");
        $rcpIndex = $this->ReceiptCounters->find('first', array('conditions' => array('condo_id' => $condo_id)));
        if (!isset($rcpIndex['ReceiptCounters']['counter'])) {
            $this->ReceiptCounters->create();
            $this->ReceiptCounters->save(array('ReceiptCounters' => array('condo_id' => $id, 'counter' => 1)));
            $index = 1;
            $id = $this->ReceiptCounters->id;
        } else {
            $id = $rcpIndex['ReceiptCounters']['id'];
        }
        $this->ReceiptCounters->read(null, $id);
        $this->ReceiptCounters->set('counter', $index);
        $this->ReceiptCounters->save();
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
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => '', 'text' => __n('Receipt', 'Receipts', 2), 'active' => 'active')
        );

        switch ($this->action) {
            case 'add_notes':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'receipts', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Receipt', 'Receipts', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => Router::url(array('controller' => 'receipts', 'action' => 'view', $this->getPhkRequestVar('receipt_id'))), 'text' => $this->getPhkRequestVar('receipt_text'), 'active' => '');
                $breadcrumbs[5] = array('link' => '', 'text' => __('Pick   Notes'), 'active' => 'active');
                break;
            case 'view':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'receipts', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Receipt', 'Receipts', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('receipt_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'receipts', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Receipt', 'Receipts', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('receipt_text'), 'active' => 'active');
                break;
        }

        $headerTitle = __n('Receipt', 'Receipts', 2);
        $this->set(compact('breadcrumbs', 'headerTitle'));
    }

}
