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
 * @since         pHKondo v 1.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');
App::uses('InvoiceConference', 'Model');

/**
 * Condos Controller
 *
 * @property Condo $Condo
 * @property PaginatorComponent $Paginator
 */
class CondosController extends AppController {

    public $uses = array('Condo', 'InvoiceConference');

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Feedback.Comments' => array('on' => array('view')));
    public $helpers = array(
        'Feedback.Comments' => array('elementIndex' => 'comment_index', 'elementForm' => 'comment_add')
    );

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $total = $this->Condo->find('count');
        $limit = Configure::read('Application.mode') == 'one' ? 2 : 50;
        $this->Paginator->settings = array_merge($this->Paginator->settings, array(
            'contain' => array('FiscalYear', 'Insurance', 'Maintenance'),
            'limit' => $limit,
        ));
        $this->setFilter(array('Condo.title', 'Condo.address'));
        $this->set('condos', $this->Paginator->paginate('Condo'));
        $this->set(compact('total','limit'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Condo->exists($id)) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('action' => 'index'));
        }
        $this->setPhkRequestVar('condo_id', $id);
        $this->Condo->contain(array(
            'Comment',
            'FiscalYear',
            'Insurance',
            'Maintenance',
            'Account',
            'Administrator' => array(
                'conditions' => array('Administrator.fiscal_year_id' => $this->getPhkRequestVar('fiscal_year_id')),
                'Entity' => array(
                    'fields' => array('Entity.name')))));
        $options = array('conditions' => array('Condo.' . $this->Condo->primaryKey => $id));
        $condo = $this->Condo->find('first', $options);
        $hasSharesDebt = $this->Condo->hasSharesDebt($id);

        $InvoiceConference = $this->InvoiceConference;
        $InvoiceConference->virtualFields = array('total_amount' => 'SUM(amount)');
        $hasDebt = 0;
        if (isset($condo['FiscalYear']) && count($condo['FiscalYear'])) {
            $hasDebt = $InvoiceConference->field('total_amount', array(
                'InvoiceConference.condo_id' => $this->getPhkRequestVar('condo_id'),
                'InvoiceConference.document_date <=' => $condo['FiscalYear'][0]['close_date'],
                'InvoiceConference.payment_due_date <' => date(Configure::read('Application.databaseDateFormat')),
                'OR' => array('InvoiceConference.payment_date' => null, 'InvoiceConference.payment_date >' => $condo['FiscalYear'][0]['close_date']),
            ));
        }
        $this->set(compact('condo', 'hasSharesDebt', 'hasDebt'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Condo->create();
            if ($this->Condo->save($this->request->data)) {
                $this->Condo->ReceiptCounter->create();
                $this->Condo->ReceiptCounter->save(array('ReceiptCounter' => array('condo_id' => $this->Condo->id, 'counter' => 0)));
                $this->Flash->success(__('The condo has been saved'));
                $this->redirect(array('action' => 'view', $this->Condo->id));
            } else {
                $this->Flash->error(__('The condo could not be saved. Please, try again.'));
            }
        }
        $total = $this->Condo->find('count');
        $limit = Configure::read('Application.mode') == 'one' ? true : false;
        if ($limit && $total>=2){
                $this->Flash->warning(__('You have reached the maximum number of condos allowed, request an account update accessing %s ','<a target="_blank" href="https://phalkaline.gumroad.com/l/phkondocloud"> GUMROAD </a>'));
                $this->redirect(array('action' => 'index'));
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
        if (!$this->Condo->exists($id)) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Condo->save($this->request->data)) {
                $this->Flash->success(__('The condo has been saved'));
                $this->redirect(array('action' => 'view', $this->Condo->id));
            } else {
                $this->Flash->error(__('The condo could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Condo.' . $this->Condo->primaryKey => $id));
            $this->request->data = $this->Condo->find('first', $options);
        }
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
        if (!in_array(AuthComponent::user('role'), array('admin', 'store_admin'))) {
            throw new MethodNotAllowedException();
        }

        $this->Condo->id = $id;
        if (!$this->Condo->exists()) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Condo->delete()) {
            $this->Flash->success(__('Condo deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Condo can not be deleted, please check the existence of already paid notes'));
        $this->redirect(array('action' => 'view', $id));
    }

    /**
     * drafts method
     *
     * @return void
     */
    public function drafts() {
        
    }

    /**
     * attachments method
     *
     * @return void
     */
    public function attachments() {
        
    }


    /**
     * shares_distribution method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function shares_distribution($id) {
        if (!$this->Condo->exists($id)) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('action' => 'index'));
        }
        
        $this->Condo->contain(array('FiscalYear'));
        $options = array('conditions' => array('Condo.' . $this->Condo->primaryKey => $id));
        $condo = $this->Condo->find('first', $options);
        $has_fiscal_year = (isset($condo['FiscalYear'][0]['title'])) ? true : false;
        if (!$has_fiscal_year){
            $this->Flash->error(__('Invalid request'));
            $this->redirect(array('action' => 'index'));
        }

        $this->setPhkRequestVar('condo_id', $id);
        
        if ($this->request->is('post') && $this->request->data['Note']['calculate']==0) {
            set_time_limit(90); 
            $title=$this->request->data['Note']['title'];
            unset($this->request->data['Note']['title']);
            $distribution_id = $this->request->data['Note']['share_distribution_id'];
            unset($this->request->data['Note']['share_distribution_id']);
            $periodicity_id = $this->request->data['Note']['share_periodicity_id'];
            unset($this->request->data['Note']['share_periodicity_id']);
            $begin_date = $this->request->data['Note']['begin_date'];
            unset($this->request->data['Note']['begin_date']);
            $due_days = $this->request->data['Note']['due_days'];
            unset($this->request->data['Note']['due_days']); 
            $shares = $this->request->data['Note']['shares'];
            unset($this->request->data['Note']['shares']); 
            $amount = $this->request->data['Note']['amount'];
            unset($this->request->data['Note']['amount']);
            unset($this->request->data['Note']['calculate']); 
            unset($this->request->data['Note']['NoteSelection']); 
 

            $notes = $this->request->data['Note'];
            App::uses('CakeTime', 'Utility');
            foreach ($notes as $key => $note) {
                // check fraction please
                if ($note['selected']==0){ continue; }
                $this->request->data['Note'] = $note;
                $this->request->data['Note']['note_type_id'] = '2';
                $this->request->data['Note']['pending_amount'] = $note['amount'];
                $shares = 1;
                $tmpDate = $begin_date;
                while ($shares <= $note['shares']):
                    $month = CakeTime::format('F', $tmpDate);
                    $this->request->data['Note']['title'] = __n('Share', 'Shares', 1) . ' ' . $shares . ' ' . __($month) . ' ' . $title;
                    $this->request->data['Note']['document_date'] = $tmpDate;
                    $this->request->data['Note']['due_date'] = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +' . $due_days . ' days'));
                    $this->request->data['Note']['note_status_id'] = '1';
                    switch ($periodicity_id):
                        case 1:
                            $tmpDate = $tmpDate;
                            break;
                        case 2:
                            $tmpDate = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +1 year'));
                            break;
                        case 3:
                            $tmpDate = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +6 months'));
                            break;
                        case 4:
                            $tmpDate = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +3 months'));
                            break;
                        case 5:
                            $tmpDate = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +1 month'));
                            break;
                        case 6:
                            $tmpDate = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +1 week'));
                            break;
                        default:
                            break;
                    endswitch;
                    $this->_addNote();
                    
                    $this->request->data['Note']['amount'] = $note['amount'];
                    $this->request->data['Note']['pending_amount'] = $note['amount'];

                    $shares++;
                endwhile;
            }
            $this->Flash->success(__('The notes has been created'));
            $this->redirect(array('action' => 'view', $id));
        }

        $this->Condo->Fraction->contain(array('Entity'));
        $fractions = $this->Condo->Fraction->find('all', array('order' => array('Fraction.fraction' => 'asc'), 'conditions' => array('condo_id' => $id)));
        $distribution['amount']=0;
        $distribution['shares']=12;
        $distribution['title']=null;
        $distribution['begin_date']=date('Y-m-d');
        $distribution['share_periodicity_id']=1;
        $distribution['share_distribution_id']=1;
        $totalMilRate = 0;
        $budgetAmount = $distribution['amount'] ? $distribution['amount'] : 0;
        $numOfShares = $distribution['shares'] ? $distribution['shares'] : 0;
        $numOfFractions = count($fractions);
        foreach ($fractions as $fraction) {
            $totalMilRate += $fraction['Fraction']['permillage'];
        }

        
        $this->loadModel('SharePeriodicity');
        $this->loadModel('ShareDistribution');
        
        $sharePeriodicities = $this->SharePeriodicity->find('list');
        $shareDistributions = $this->ShareDistribution->find('list');
     
    
        $this->set(compact('fractions', 'distribution', 'condo', 'sharePeriodicities', 'shareDistributions'));
    }

    private function _addNote() {
        $this->loadModel('Note');
        $this->Note->create();
        $this->request->data['Note']['fiscal_year_id'] = $this->getPhkRequestVar('fiscal_year_id');
        if ($this->Note->save($this->request->data)) {
            $this->_setDocument();
        } 
    }

    /* private function _getFiscalYear() {
      $this->Note->Budget->id = $this->request->data['Note']['budget_id'];
      $fiscalYear = $this->Note->Budget->field('fiscal_year_id');
      return $fiscalYear;
      } */

    private function _setDocument() {
        if (is_array($this->request->data['Note']['document_date'])) {
            $dateTmp = $this->request->data['Note']['document_date']['day'] . '-' . $this->request->data['Note']['document_date']['month'] . '-' . $this->request->data['Note']['document_date']['year'];
            $this->request->data['Note']['document_date'] = $dateTmp;
        };
        //debug($this->request->data['Note']['document_date']);
        $date = new DateTime($this->request->data['Note']['document_date']);
        $dateResult = $date->format('Y');
        $document = $this->Note->id . '-' . $this->request->data['Note']['note_type_id'];
        $this->Note->saveField('document', $document);
        return true;
    }

    public function beforeRender() {
        parent::beforeRender();
        if (!isset($this->phkRequestData['condo_id'])) {
            $breadcrumbs = array(
                array('link' => '', 'text' => __n('Condo', 'Condos', 2), 'active' => 'active')
            );
            $headerTitle = __('Condos');
        } else {
            $breadcrumbs = array(
                array('link' => '', 'text' => $this->getPhkRequestVar('condo_text') . ' ( ' . $this->phkRequestData['fiscal_year_text'] . ' ) ', 'active' => 'active'),
            );
            $headerTitle = __('Condos');
        }

        $this->set(compact('breadcrumbs', 'headerTitle'));
    }

}
