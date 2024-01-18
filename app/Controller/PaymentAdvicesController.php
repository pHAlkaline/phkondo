<?php

/**
 *
 * pHKondo : pHKondo software for condominium hoa association management (https://phalkaline.net)
 * Copyright (c) pHAlkaline . (https://phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (https://phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @package       app.Controller
 * @since         pHKondo v 10.1.3
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');
App::uses('CakeEvent', 'Event');

/**
 * Payment Advices Controller
 *
 * @property  $PaymentAdvice
 * @property PaginatorComponent $Paginator
 */
class PaymentAdvicesController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'RequestHandler');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->setConditions();
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings, array(
            'contain' => array('Fraction', 'Entity', 'PaymentType'),
            'conditions' => array(
                'PaymentAdvice.condo_id' => $this->getPhkRequestVar('condo_id'),
            ),
        ));
        $this->setFilter(array('PaymentAdvice.document', 'Entity.name', 'PaymentAdvice.name', 'PaymentType.name', 'PaymentAdvice.total_amount'));
        $this->set('payment_advices', $this->Paginator->paginate('PaymentAdvice'));
    }

    private function setConditions()
    {
        $filterOptions['conditions'] = array();
        $queryData = array();
        if (isset($this->request->query)) {
            $queryData = $this->request->query;
        }


        $start_date = $close_date = $entity_id = $hasAdvSearch = false;
        if (isset($queryData['start_date']) && $queryData['start_date'] != '' && isset($queryData['close_date']) && $queryData['close_date'] != '') {

            $start_date = date(Configure::read('Application.databaseDateFormat'), strtotime($queryData['start_date']));
            $close_date = date(Configure::read('Application.databaseDateFormat'), strtotime($queryData['close_date']));

            $filterOptions['conditions'] = array_merge($filterOptions['conditions'], array('PaymentAdvice.document_date between ? and ?' => array($start_date, $close_date)));
            $this->request->data['PaymentAdvice']['start_date'] = $queryData['start_date'];
            $this->request->data['PaymentAdvice']['close_date'] = $queryData['close_date'];
            $hasAdvSearch = true;
        }


        if (isset($queryData['entity_id']) && $queryData['entity_id'] != null) {
            $entity_id = $queryData['entity_id'];
            $filterOptions['conditions'] = array_merge($filterOptions['conditions'], array('PaymentAdvice.entity_id' => $entity_id));
            $this->request->data['PaymentAdvice']['entity_id'] = $queryData['entity_id'];
            $hasAdvSearch = true;
        }
        $this->PaymentAdvice->Fraction->contain('Entity');
        $fractionsForClients = $this->PaymentAdvice->Fraction->find('all', array('conditions' => array('Fraction.condo_id' => $this->getPhkRequestVar('condo_id'))));
        $entities = $this->PaymentAdvice->Entity->find('list', array('order' => 'Entity.name', 'conditions' => array('Entity.id' => Set::extract('/Entity/id', $fractionsForClients))));

        $receiptDates = $this->PaymentAdvice->find('first', array('fields' => array('MIN(document_date) AS start_date', 'MAX(document_date) AS close_date'), 'conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));
        $receiptDates = isset($receiptDates[0]) ? $receiptDates[0] : null;
        $this->set(compact('entities', 'receiptDates', 'hasAdvSearch'));


        $paginateConditions = array();
        if (isset($this->Paginator->settings['conditions'])) {
            $paginateConditions = $this->Paginator->settings['conditions'];
            $this->Paginator->settings['conditions'] = array_replace_recursive($this->Paginator->settings['conditions'], $filterOptions['conditions']);
        } else {
            $this->Paginator->settings['conditions'] = $filterOptions['conditions'];
        }
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
        if (!$this->PaymentAdvice->exists($id)) {
            $this->Flash->error(__('Invalid payment advice'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $this->PaymentAdvice->contain(array(
            'Fraction',
            'Entity',
            'PaymentType',
            'Receipt',
            'Note' => array('NoteType', 'Fraction')
        ));
        $options = array('conditions' => array('PaymentAdvice.' . $this->PaymentAdvice->primaryKey => $id, 'PaymentAdvice.condo_id' => $this->getPhkRequestVar('condo_id')));
        $paymentAdvice = $this->PaymentAdvice->find('first', $options);
        $this->PaymentAdvice->Entity->order = 'Entity.name';
        $notificationEntities = $this->Session->read('NotificationEntities') ? $this->Session->consume('NotificationEntities') : $this->PaymentAdvice->Entity->find('list', array('fields' => array('Entity.email', 'Entity.email'), 'conditions' => array('id' => $paymentAdvice['Entity']['id'])));

        $emailNotifications = Configure::read('EmailNotifications');
        $this->set(compact('paymentAdvice', 'notificationEntities', 'emailNotifications'));
        $this->setPhkRequestVar('payment_advice_id', $id);
    }

    /**
     * print method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function print($id)
    {
        if (!$this->PaymentAdvice->exists($id)) {
            $this->Flash->error(__('Invalid payment advice'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }

        $event = new CakeEvent('Phkondo.PaymentAdvice.print', $this, array(
            'id' => $id,
        ));
        $this->getEventManager()->dispatch($event);
    }

    /**
     * send method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function send($id)
    {
        if (Configure::read('Application.stage') == 'demo') {
            $this->Flash->success(__d('email', 'Email sent with success.'));
            $this->Flash->warning(__d('email', 'In Demo Sessions this feature is disbled to avoid spam!!.'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }

        if (!$this->PaymentAdvice->exists($id)) {
            $this->Flash->error(__('Invalid payment advice'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $notificationEntities = array_combine($this->request->data['PaymentAdvice']['send_to'], $this->request->data['PaymentAdvice']['send_to']);
        $this->Session->write('NotificationEntities', $notificationEntities);
        $event = new CakeEvent('Phkondo.PaymentAdvice.send', $this, array(
            'id' => $id,
        ));
        $this->getEventManager()->dispatch($event);
    }

    /**
     * bulk_send method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function ajax_send($id)
    {
        $this->request->onlyAllow('ajax');
        $this->autoRender = false;
        if (Configure::read('Application.stage') == 'demo') {
            echo json_encode(array('result' => false, 'error' =>__d('email', 'In Demo Sessions this feature is disbled to avoid spam!!.')));
            return;
        }

        if (!$this->PaymentAdvice->exists($id)) {
            echo json_encode(array('result' => false, 'error' =>__('Invalid payment advice!!.')));
            return;
        }
        
        $event = new CakeEvent('Phkondo.PaymentAdvice.ajax_send', $this, array(
            'id' => $id,
        ));
        $result=$this->getEventManager()->dispatch($event);

        echo json_encode(array('result' => $result['result']));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post') && isset($this->request->data['PaymentAdvice']['change_filter']) && $this->request->data['PaymentAdvice']['change_filter'] != '1') {
            $this->PaymentAdvice->create();
            $this->PaymentAdvice->Entity->id = $this->request->data['PaymentAdvice']['entity_id'];
            $entity=$this->PaymentAdvice->Entity->read();
        
            $this->request->data['PaymentAdvice']['address'] = $entity['Entity']['address'];
            //$number = $this->PaymentAdvice->getNextIndex($this->getPhkRequestVar('condo_id'));
            $this->request->data['PaymentAdvice']['document'] =$this->getPhkRequestVar('condo_id') .$this->request->data['PaymentAdvice']['fraction_id'] .$entity['id'].'-'.Date('YmdHis');
            if ($this->request->data['PaymentAdvice']['document_date'] == '') {
                $this->request->data['PaymentAdvice']['document_date'] = date(Configure::read('Application.dateFormatSimple'));
            }
            if ($this->PaymentAdvice->save($this->request->data)) {
                //$this->PaymentAdvice->setPaymentAdviceIndex($this->getPhkRequestVar('condo_id'), $number);
                $this->Flash->success(__('The payment advice has been saved'));
                $this->redirect(array('action' => 'edit', $this->PaymentAdvice->id, '?' => $this->request->query, '#' => 'AddNotes'));
            } else {
                //debug($this->PaymentAdvice->validationErrors);
                $this->Flash->error(__('The payment advice could not be saved. Please, try again.'));
            }
        }
        $condos = $this->PaymentAdvice->Condo->find('list', array('conditions' => array('Condo.id' => $this->getPhkRequestVar('condo_id'))));
        $fractions = $this->PaymentAdvice->Condo->Fraction->find('list', array('conditions' => array('Fraction.condo_id' => $this->getPhkRequestVar('condo_id'))));

        if (!isset($this->request->data['PaymentAdvice']['fraction_id'])) {
            $fractionsForClients = $fractions;
            reset($fractionsForClients);
            $firstFraction = key($fractionsForClients);
        } else {
            $firstFraction = $this->request->data['PaymentAdvice']['fraction_id'];
        }
        $this->PaymentAdvice->Fraction->contain('Entity');
        $fractionsForClients = $this->PaymentAdvice->Fraction->find('all', array('conditions' => array('Fraction.id' => $firstFraction)));
        $entities = $this->PaymentAdvice->Entity->find('list', array('order' => 'Entity.name', 'conditions' => array('Entity.id' => Set::extract('/Entity/id', $fractionsForClients))));
        $paymentTypes = $this->PaymentAdvice->PaymentType->find('list', array('conditions' => array('active' => '1')));
        unset($this->request->data['PaymentAdvice']['change_filter']);
        $this->set(compact('condos', 'fractions', 'entities', 'paymentTypes'));
    }

    /**
     * add_notes method
     *
     * @return void
     */
    public function add_notes($id)
    {

        if (!$this->PaymentAdvice->editable($id)) {
            $this->Flash->error(__('Invalid payment advice'));
            $this->redirect(array('action' => 'index', $id, '?' => $this->request->query));
        }

        if ($this->request->is('post') && isset($this->request->data['Note'])) {
            $this->PaymentAdvice->Note->updateAll(
                array(
                    'Note.payment_advice_id' => null,
                    'Note.pending_amount' => 0
                ),
                array(
                    'Note.fraction_id' => $this->request->data['Fraction']['id'],
                    'Note.entity_id' => $this->PaymentAdvice->field('entity_id'),
                    'Note.note_status_id' => array(1, 2),
                    'Note.payment_advice_id' => $id
                )
            );
            $this->PaymentAdvice->setAmount($id);
            foreach ($this->request->data['Note'] as $key => $note) {

                if (isset($note['check'])) {

                    $noteOk = $this->PaymentAdvice->Note->find('count', array('conditions' => array('Note.id' => $key, 'Note.receipt_id' => null)));

                    if ($noteOk == 0) {
                        $this->Flash->error(__('The notes could not be saved. Please, try again.'));
                        $this->redirect(array('action' => 'edit', $id, '?' => $this->request->query, '#' => 'AddNotes'));
                        return;
                    }
                    $this->PaymentAdvice->Note->id = $key;
                    $this->PaymentAdvice->Note->saveField('payment_advice_id', $id, array('callbacks' => false));
                    $this->PaymentAdvice->Note->saveField('pending_amount', '0', array('callbacks' => false));
                }
            }
            $this->PaymentAdvice->setAmount($id);
            $this->Flash->success(__('The payment advice has been saved'));
            //$this->redirect(array('action' => 'edit', $id, '#' => 'AddNotes'));
        }
        $this->redirect(array('action' => 'edit', $id, '?' => $this->request->query, '#' => 'AddNotes'));
    }

    /**
     * generate method
     *
     * @return void
     */
    public function generate()
    {
        if ($this->request->is('post')) {
            set_time_limit(90);
            $result = true;
            $dataSource = $this->PaymentAdvice->getDataSource();
            $dataSource->begin();
            try {
                $this->PaymentAdvice->Condo->contain('Fraction.Entity');
                $condo = $this->PaymentAdvice->Condo->find('first', array('conditions' => array('Condo.id' => $this->request->data['PaymentAdvice']['condo_id'])));
                if (isset($condo['Fraction']) && count($condo['Fraction']) > 0) {
                    foreach ($condo['Fraction'] as $fraction) {
                        if (isset($fraction['Entity']) && count($fraction['Entity']) > 0) {
                            foreach ($fraction['Entity'] as $entity) {
                                /*$this->PaymentAdvice->Note->updateAll(
                                    array(
                                        'Note.payment_advice_id' => null,
                                        'Note.pending_amount' => 0
                                    ),
                                    array(
                                        'Note.fraction_id' => $fraction['id'],
                                        'Note.entity_id' => $entity['id'],
                                        'Note.note_status_id' => array(1, 2),
                                        'Note.receipt_id' => null
                                    )
                                );*/
                                $this->PaymentAdvice->deleteAll(array(
                                    'PaymentAdvice.fraction_id' => $fraction['id'],
                                    'PaymentAdvice.entity_id' => $entity['id'],
                                    'PaymentAdvice.payment_date'=> null,
                                    'PaymentAdvice.receipt_id'=> null
                                ), true);
                                $notes = $this->PaymentAdvice->Note->find(
                                    'all',
                                    array(
                                        'conditions' => array(
                                            'AND' => array(
                                                'Note.payment_advice_id IS NULL',
                                                'Note.receipt_id IS NULL',
                                                'Note.fraction_id' => $fraction['id'],
                                                'Note.entity_id' => $entity['id'],
                                                'Note.note_status_id' => array(1, 2),
                                                'Note.due_date <=' => $this->request->data['PaymentAdvice']['due_date']
                                            ),
                                        )
                                    )
                                );
                                if (count($notes) > 0) {
                                    $this->PaymentAdvice->create();
                                    $this->PaymentAdvice->Entity->id = $entity['id'];
                                    $this->PaymentAdvice->Entity->order = 'Entity.name';
                                    $this->request->data['PaymentAdvice']['fraction_id']=$fraction['id'];
                                    $this->request->data['PaymentAdvice']['entity_id']=$entity['id'];
                                    $this->request->data['PaymentAdvice']['address'] = $this->PaymentAdvice->Entity->field('address');
                                    $this->request->data['PaymentAdvice']['document'] = $this->getPhkRequestVar('condo_id') . $fraction['id'] .$entity['id'].'-'.Date('YmdHis');
                                    if ($this->request->data['PaymentAdvice']['document_date'] == '') {
                                        $this->request->data['PaymentAdvice']['document_date'] = date(Configure::read('Application.dateFormatSimple'));
                                    }
                                    if ($this->PaymentAdvice->save($this->request->data)) {
                                        $this->PaymentAdvice->setAmount($this->PaymentAdvice->id);
                                        foreach ($notes as $note) {
                                           
                                                $noteOk = $this->PaymentAdvice->Note->find('count', array('conditions' => array('Note.id' => $note['Note']['id'], 'Note.receipt_id' => null)));
                                                if ($noteOk == 0) {
                                                    $this->Flash->error(__('The notes could not be saved. Please, try again.'));
                                                }
                                                $this->PaymentAdvice->Note->id = $note['Note']['id'];
                                                $this->PaymentAdvice->Note->saveField('payment_advice_id', $this->PaymentAdvice->id, array('callbacks' => false));
                                                $this->PaymentAdvice->Note->saveField('pending_amount', '0', array('callbacks' => false));
                                    
                                        }
                                        $this->PaymentAdvice->setAmount($this->PaymentAdvice->id);
                                    } else {
                                        $result = false;
                                    }
                                }
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                $result = false;
            }
            if ($result) {
                $dataSource->commit();
                $this->Flash->success(__('The payment advices has been created'));
            } else {
                $dataSource->rollback();
                $this->Flash->error(__('The payment advices could not be created. Please, try again.'));
            }
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $condos = $this->PaymentAdvice->Condo->find('list', array('conditions' => array('Condo.id' => $this->getPhkRequestVar('condo_id'))));
        $fractions[0] = __('All');
        $entities[0] = __('All');
        $this->set(compact('condos', 'fractions', 'entities'));
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
        if (!$this->PaymentAdvice->exists($id)) {
            $this->Flash->error(__('Invalid payment advice'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }

        if (!$this->PaymentAdvice->editable($id)) {
            $this->Flash->error(__('Invalid payment advice'));
            $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['PaymentAdvice']['payment_date']) && $this->request->data['PaymentAdvice']['payment_date'] == '') {
                $this->request->data['PaymentAdvice']['payment_date'] = null;
            }
            if ($this->PaymentAdvice->save($this->request->data)) {
                $this->Flash->success(__('The payment advice has been saved'));
                $this->redirect(array('action' => 'edit', $id, '?' => $this->request->query, '#' => 'Details'));
            } else {
                $this->Flash->error(__('The payment advice could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('PaymentAdvice.' . $this->PaymentAdvice->primaryKey => $id));
            //$this->PaymentAdvice->contain(array('Note' => array('NoteType', 'Fraction')));

            $this->request->data = $this->PaymentAdvice->find('first', $options);
            if (empty($this->request->data)) {
                $this->Flash->error(__('Invalid payment advice'));
                $this->redirect(array('action' => 'index', '?' => $this->request->query));
            }
        }

        $condos = $this->PaymentAdvice->Condo->find('list', array('conditions' => array('id' => $this->request->data['PaymentAdvice']['condo_id'])));
        $fractions = $this->PaymentAdvice->Fraction->find('list', array('conditions' => array('Fraction.id' => $this->request->data['PaymentAdvice']['fraction_id'])));
        $entities = $this->PaymentAdvice->Entity->find('list', array('order' => 'Entity.name', 'conditions' => array('id' => $this->request->data['PaymentAdvice']['entity_id'])));
        $paymentTypes = $this->PaymentAdvice->PaymentType->find('list', array('conditions' => array('active' => '1')));
        $this->PaymentAdvice->Note->contain(array('NoteType', 'Entity', 'Fraction'));

        $notes = $this->PaymentAdvice->Note->find(
            'all',
            array(
                'conditions' => array(
                    'AND' => array(
                        'OR' => array('Note.payment_advice_id IS NULL', 'Note.payment_advice_id' => $id),
                        'Note.receipt_id IS NULL',
                        'Note.fraction_id' => $this->PaymentAdvice->field('fraction_id'),
                        'Note.entity_id' => $this->PaymentAdvice->field('entity_id'),
                        'Note.note_status_id' => array(1, 2),
                        'Note.due_date <=' => $this->PaymentAdvice->field('due_date')
                    ),
                )
            )
        );
        $paymentAdviceAmount = 0; //$this->PaymentAdvice->field('total_amount');
        $paymentAdviceId = $this->PaymentAdvice->field('document');
        $this->set(compact('notes', 'paymentAdviceAmount', 'paymentAdviceId', 'id'));
        $this->set(compact('condos', 'fractions', 'entities', 'paymentTypes'));
        $this->setPhkRequestVar('payment_advice_id', $id);
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
        $this->PaymentAdvice->id = $id;
        if (!$this->PaymentAdvice->exists()) {
            $this->Flash->error(__('Invalid payment advice'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $this->PaymentAdvice->read();
        if ($this->PaymentAdvice->delete()) {
            $this->Flash->success(__('PaymentAdvice deleted'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $this->Flash->error(__('PaymentAdvice can not be deleted'));
        $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
    }


    public function beforeFilter()
    {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('condo_id')) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('controller' => 'condos', 'action' => 'index'));
        }
    }

    public function beforeRender()
    {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text') . ' ( ' . $this->phkRequestData['fiscal_year_text'] . ' ) ', 'active' => ''),
            array('link' => Router::url(array('controller' => 'payment_advices', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Payment Advice', 'Payment Advices', 2), 'active' => 'active')
        );

        switch ($this->action) {
            case 'add_notes':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'payment_advices', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Payment Advice', 'Payment Advices', 2), 'active' => '');
                $breadcrumbs[2] = array('link' => Router::url(array('controller' => 'payment_advices', 'action' => 'view', $this->getPhkRequestVar('payment_advice_id'))), 'text' => $this->getPhkRequestVar('payment_advice_text'), 'active' => '');
                $breadcrumbs[3] = array('link' => '', 'text' => __('Pick Notes'), 'active' => 'active');
                break;
            case 'view':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'payment_advices', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Payment Advice', 'Payment Advices', 2), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('payment_advice_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'payment_advices', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Payment Advice', 'Payment Advices', 2), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('payment_advice_text'), 'active' => 'active');
                break;
        }

        $headerTitle = __n('Payment Advice', 'Payment Advices', 2);
        $this->set(compact('breadcrumbs', 'headerTitle'));
    }
}
