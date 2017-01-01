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
 * Budgets Controller
 *
 * @property Budget $Budget
 * @property PaginatorComponent $Paginator
 */
class BudgetsController extends AppController {

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
    public function index() {
        
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings , array(
            'contain' => array('BudgetType', 'BudgetStatus'),
            'conditions' => array(
                'Budget.condo_id' => $this->getPhkRequestVar('condo_id'))
        ));
        $this->setFilter(array('Budget.title', 'BudgetType.name'));
        $this->set('budgets', $this->Paginator->paginate('Budget'));
        
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Budget->contain(array('Note', 'BudgetStatus', 'FiscalYear', 'BudgetType', 'SharePeriodicity', 'ShareDistribution'));
        if (!$this->Budget->exists($id)) {
            $this->Flash->error(__('Invalid budget'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $options = array('conditions' => array('Budget.' . $this->Budget->primaryKey => $id));
        $budget = $this->Budget->find('first', $options);
        $this->set(compact('budget'));
        $this->setPhkRequestVar('budget_id',$id);
        $this->setPhkRequestVar('budget_text',$budget['Budget']['title']);
        $this->setPhkRequestVar('budget_status',$budget['Budget']['budget_status_id']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            if ($this->request->data['Budget']['share_periodicity_id'] == 1) {
                $this->request->data['Budget']['shares'] = 1;
            }
            $this->Budget->create();
            $this->request->data['Budget']['requested_amount'] = $this->request->data['Budget']['amount'];
            if ($this->Budget->save($this->request->data)) {
                $this->Flash->success(__('The budget has been saved'));
                $this->redirect(array('action' => 'view', $this->Budget->id,'?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The budget could not be saved. Please, try again.'));
            }
        }
        $condos = $this->Budget->Condo->find('list', array('conditions' => array('id' => $this->phkRequestData['condo_id'])));
        $fiscalYears = $this->Budget->FiscalYear->find('list', array('conditions' => array('id' => $this->phkRequestData['fiscal_year_id'])));
        $fiscalYearData= $this->Budget->FiscalYear->find('first', array('fields'=>array('open_date','close_date'),'conditions' => array('id' => $this->getPhkRequestVar('fiscal_year_id'))));
        $budgetTypes = $this->Budget->BudgetType->find('list');
        $budgetStatuses = $this->Budget->BudgetStatus->find('list', array('conditions' => array('id' => array('1', '2'))));
        $sharePeriodicities = $this->Budget->SharePeriodicity->find('list');
        $shareDistributions = $this->Budget->ShareDistribution->find('list');
        $this->set(compact('condos', 'fiscalYears', 'budgetTypes', 'budgetStatuses', 'sharePeriodicities', 'shareDistributions','fiscalYearData'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Budget->exists($id)) {
            $this->Flash->error(__('Invalid budget'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Budget->contain(array('Note'));
        $options = array('conditions' => array('Budget.' . $this->Budget->primaryKey => $id));
        $budget = $this->Budget->find('first', $options);
        $this->set(compact('budget'));
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['Budget']['share_periodicity_id']) && $this->request->data['Budget']['share_periodicity_id'] == 1) {
                $this->request->data['Budget']['shares'] = 1;
                $this->request->data['Budget']['requested_amount'] = $this->request->data['Budget']['amount'];
            }

            if ($this->Budget->save($this->request->data)) {
                $this->_setNotesStatus();
                $this->Flash->success(__('The budget has been saved'));
                $this->redirect(array('action' => 'view', $this->Budget->id,'?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The budget could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $budget;
        }

        if ($this->request->data['Budget']['fiscal_year_id'] != $this->getPhkRequestVar('fiscal_year_id')) {
            $this->Flash->error(__('Invalid budget'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $condos = $this->Budget->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $fiscalYears = $this->Budget->FiscalYear->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('fiscal_year_id'))));
         $fiscalYearData= $this->Budget->FiscalYear->find('first', array('fields'=>array('open_date','close_date'),'conditions' => array('id' => $this->getPhkRequestVar('fiscal_year_id'))));
        $budgetTypes = $this->Budget->BudgetType->find('list');
        $budgetStatuses = $this->Budget->BudgetStatus->find('list');
        $sharePeriodicities = $this->Budget->SharePeriodicity->find('list');
        $shareDistributions = $this->Budget->ShareDistribution->find('list');
        $this->set(compact('condos', 'fiscalYears', 'budgetTypes', 'budgetStatuses', 'sharePeriodicities', 'shareDistributions','fiscalYearData'));
        $this->setPhkRequestVar('budget_id',$id);
        $this->setPhkRequestVar('budget_text',$this->request->data['Budget']['title']);
        $this->setPhkRequestVar('budget_status',$this->request->data['Budget']['budget_status_id']);
       
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
        $this->Budget->id = $id;
        if (!$this->Budget->exists()) {
            $this->Flash->error(__('Invalid budget'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }

        if (!$this->Budget->deletable()) {
            $this->Flash->error(__('This Budget can not be deleted, check budget status or existing notes already paid.'));
            $this->redirect(array('action' => 'view', $id,'?'=>$this->request->query));
        }

        if ($this->Budget->Note->DeleteAll(array('Note.budget_id' => $id), false) && $this->Budget->delete()) {
            $this->Flash->success(__('Budget deleted'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Flash->error(__('Budget can not be deleted'));
        $this->redirect(array('action' => 'view', $id,'?'=>$this->request->query));
    }

    /**
     * share_map method
     *
     * @return void
     */
    public function shares_map($id = null) {
        if (!$this->Budget->exists($id)) {
            $this->Flash->error(__('Invalid budget'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }

        $event = new CakeEvent('Phkondo.Budget.sharesMap', $this, array(
            'id' => $id,
        ));
        $this->getEventManager()->dispatch($event);
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('condo_id') || !$this->getPhkRequestVar('fiscal_year_id')) {
            $this->Flash->error(__('Invalid condo or fiscal year'));
            $this->redirect(array('controller'=>'condos','action' => 'index'));
        }
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo', 'Condos', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => '', 'text' => __n('Budget', 'Budgets', 2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'budgets', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Budget', 'Budgets', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('budget_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'budgets', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Budget', 'Budgets', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('budget_text'), 'active' => 'active');
                break;
        }
        $headerTitle=__n('Budget', 'Budgets', 2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

    private function _setNotesStatus() {
        $db = $this->Budget->getDataSource();
        $now = $db->value(date(Configure::read('databaseDateFormat') . ' H:i:s'), 'string');
        switch ($this->request->data['Budget']['budget_status_id']) {
            case '1':
                $this->Budget->Note->updateAll(
                        array('Note.note_status_id' => '1', 'Note.modified' => $now), array('Note.budget_id' => $this->Budget->id, 'Note.note_status_id' => '4')
                );
                break;
            case '2':
                $this->Budget->Note->updateAll(
                        array('Note.note_status_id' => '1', 'Note.modified' => $now), array('Note.budget_id' => $this->Budget->id, 'Note.note_status_id' => '4')
                );
                break;
            case '4':
                $this->Budget->Note->updateAll(
                        array('Note.note_status_id' => '4', 'Note.modified' => $now), array('Note.budget_id' => $this->Budget->id, 'Note.note_status_id' => '1')
                );
                break;
        }
    }

}
