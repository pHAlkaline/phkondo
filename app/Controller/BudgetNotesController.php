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
 * BudgetNotes Controller
 *
 * @property Note $Note
 * @property PaginatorComponent $Paginator
 */
class BudgetNotesController extends AppController {

    /**
     * Uses
     *
     * @var array
     */
    public $uses = array('Note');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->setConditions();
        $options['conditions'] = array('Note.budget_id' => $this->phkRequestData['budget_id']);
        $options['order'] = array('Note.id' => 'asc', 'Note.document_date' => 'asc', 'Note.document' => 'asc');

        if (isset($this->Paginator->settings['conditions'])) {
            $options['conditions'] = array_replace_recursive($this->Paginator->settings['conditions'], $options['conditions']);
        }
        if (isset($this->Paginator->settings['order'])) {
            $options['order'] = array_replace_recursive($this->Paginator->settings['order'], $options['order']);
        }
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings,array(
            'conditions' => $options['conditions'],
            'order' => $options['order'],
            //'requiresAcessLevel' => true,
            'contain' => array('NoteType', 'Entity', 'NoteStatus','Fraction')));
        
        $this->setFilter(array('Note.document', 'Note.title', 'NoteType.name', 'Entity.name', 'Note.amount', 'NoteStatus.name', 'Fraction.description'));
        $this->set('notes', $this->Paginator->paginate('Note'));
    }
    
      
    private function setConditions(){
        $filterOptions['conditions'] = array();
        $queryData = array();
        if (isset($this->request->query)) {
            $queryData = $this->request->query;
        }

        $note_status_id = $entity_id = $hasAdvSearch = false;
        if (isset($queryData['note_status_id']) && $queryData['note_status_id'] != null) {
            $note_status_id = $queryData['note_status_id'];
            $filterOptions['conditions'] = array_merge($filterOptions['conditions'], array('Note.note_status_id' => $note_status_id));
            $this->request->data['Note']['note_status_id'] = $queryData['note_status_id'];
            $hasAdvSearch = true;
        }
        $noteStatuses = $this->Note->NoteStatus->find('list', array( 'order' => 'name', 'conditions' => array('active' => 1)));
        
        if (isset($queryData['entity_id']) && $queryData['entity_id'] != null) {
            $entity_id = $queryData['entity_id'];
            $filterOptions['conditions'] = array_merge($filterOptions['conditions'], array('Note.entity_id' => $entity_id));
            $this->request->data['Note']['entity_id'] = $queryData['entity_id'];
            $hasAdvSearch = true;
        }
        
        $this->Note->contain(array('Entity'=>array('fields'=>array('Entity.id'))));
        $entitiesFilter = $this->Note->find('all', array('fields' => array('Note.id'), 'conditions' => array( 'budget_id' => $this->getPhkRequestVar('budget_id'))));
        $entities = $this->Note->Entity->find('list', array('conditions' => array('id' => Set::extract('/Entity/id', $entitiesFilter))));
        $this->set(compact('noteStatuses', 'entities', 'hasAdvSearch'));


        $paginateConditions = array();
        if (isset($this->Paginator->settings['conditions'])) {
            $paginateConditions = $this->Paginator->settings['conditions'];
            $this->Paginator->settings['conditions'] = array_replace_recursive($this->Paginator->settings['conditions'] , $filterOptions['conditions']);
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
    public function view($id = null) {
        if (!$this->Note->exists($id)) {
            $this->Flash->error(__('Invalid note'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $this->Note->contain(array('NoteType', 'Fraction', 'Entity', 'Budget', 'FiscalYear', 'NoteStatus', 'Receipt'));
        $options = array('conditions' => array(
                'Note.' . $this->Note->primaryKey => $id,
                'Note.budget_id' => $this->getPhkRequestVar('budget_id')));
        $note = $this->Note->find('first', $options);
        $this->set(compact('note'));
        $this->setPhkRequestVar('note_id', $id);
        $this->setPhkRequestVar('note_title', $note['Note']['title']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Note->create();
            $this->request->data['Note']['fiscal_year_id'] = $this->getPhkRequestVar('fiscal_year_id');
            $this->request->data['Note']['pending_amount'] = $this->request->data['Note']['amount'];
            if ($this->Note->save($this->request->data)) {
                $this->_setDocument();
                $this->Flash->success(__('The note has been saved'));
                $this->redirect(array('action' => 'view', $this->Note->id, '?' => $this->request->query));
            } else {
                $this->Flash->error(__('The note could not be saved. Please, try again.'));
            }
        }
        $noteTypes = $this->Note->NoteType->find('list', array('conditions' => array('NoteType.id' => '2')));
        $fractions = $this->Note->Fraction->find('list', array('order' => array('Fraction.length' => 'asc', 'Fraction.fraction' => 'asc'), 'conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));
        $budgets = $this->Note->Budget->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('budget_id'))));
        //$fiscalYears = $this->Note->FiscalYear->find('list', array('conditions' => array('id' => Set::extract('/Budget/id', $budgets))));
        $entitiesFilter = $this->Note->Fraction->find('all', array('fields' => array('Fraction.id'), 'conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'), 'Fraction.id' => array_keys($fractions))));
        $entities = $this->Note->Entity->find('list', array('conditions' => array('id' => Set::extract('/Entity/id', $entitiesFilter))));

        $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('active' => '1')));
        $this->set(compact('noteTypes', 'fractions', 'fiscalYears', 'entities', 'budgets', 'noteStatuses'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {

        if (!$this->Note->exists($id)) {
            $this->Flash->error(__('Invalid note'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Note']['fiscal_year_id'] = $this->getPhkRequestVar('fiscal_year_id');
            if ($this->Note->save($this->request->data)) {
                $this->_setDocument();
                $this->Flash->success(__('The note has been saved'));
                $this->redirect(array('action' => 'view', $this->Note->id, '?' => $this->request->query));
            } else {
                $this->Flash->error(__('The note could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array(
                    'Note.' . $this->Note->primaryKey => $id,
                    'Note.budget_id' => $this->getPhkRequestVar('budget_id')));

            $this->request->data = $this->Note->find('first', $options);
            if (!$this->Note->editable($this->request->data['Note'])) {
                $this->Flash->error(__('Invalid Note'));
                $this->redirect(array('action' => 'view', $this->Note->id, '?' => $this->request->query));
            }
        }
        $noteTypes = $this->Note->NoteType->find('list');
        $fractions = $this->Note->Fraction->find('list', array('order' => array('Fraction.length' => 'asc', 'Fraction.fraction' => 'asc'), 'conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));
        $budgets = $this->Note->Budget->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('budget_id'))));
        $fiscalYears = $this->Note->FiscalYear->find('list', array('conditions' => array('id' => Set::extract('/Budget/id', $budgets))));
        $entitiesFilter = $this->Note->Fraction->find('all', array('fields' => array('Fraction.id'), 'conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id')))); //'Fraction.id' => $this->request->data['Note']['fraction_id']
        $entities = $this->Note->Entity->find('list', array('conditions' => array('id' => Set::extract('/Entity/id', $entitiesFilter))));

        if ($this->request->data['Note']['receipt_id'] != null) {
            $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('id' => $this->request->data['Note']['note_status_id'])));
        } else {
            $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('active' => '1')));
        }
        $this->set(compact('noteTypes', 'fractions', 'fiscalYears', 'entities', 'budgets', 'noteStatuses'));
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
        $this->Note->id = $id;
        if (!$this->Note->exists()) {
            $this->Flash->error(__('Invalid note'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        if ($this->Note->delete()) {
            $this->Flash->success(__('Note deleted'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $this->Flash->error(__('Note can not be deleted'));
        $this->redirect(array('action' => 'view', $id, '?' => $this->request->query));
    }

    /**
     * delete create
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function create() {
        $this->Note->Budget->contain(array('Note', 'BudgetStatus', 'FiscalYear', 'BudgetType', 'SharePeriodicity', 'ShareDistribution'));
        $budget = $this->Note->Budget->find('first', array('conditions' => array('Budget.id' => $this->getPhkRequestVar('budget_id'), 'Budget.budget_status_id' => '2')));
        if (empty($budget)) {
            $this->Flash->error(__('Invalid Budget'));
            $this->redirect(array('controller' => 'budgets', 'action' => 'index', '?' => array('condo_id' => $this->phkRequestData['condo_id'])));
        }
        if (isset($budget['Note']) && count($budget['Note']) > 0) {
            $this->Flash->error(__('Invalid Budget'));
            $this->redirect(array('controller' => 'budgets', 'action' => 'index', '?' => array('condo_id' => $this->phkRequestData['condo_id'])));
        }

        if ($this->request->is('post')) {
            $notes = $this->request->data['Note'];

            unset($notes['Budget']);
            App::uses('CakeTime', 'Utility');
            foreach ($notes as $key => $note) {
                // check fraction please
                $this->request->data['Note'] = $note;
                $this->request->data['Note']['budget_id'] = $budget['Budget']['id'];
                $this->request->data['Note']['note_type_id'] = '2';
                $this->request->data['Note']['pending_amount'] = $note['amount'];
                $shares = 1;
                $tmpDate = $budget['Budget']['begin_date'];
                while ($shares <= $note['shares']):
                    $month = CakeTime::format('F', $tmpDate);
                    $this->request->data['Note']['title'] = __n('Share', 'Shares', 1) . ' ' . $shares . ' ' . __($month) . ' ' . $budget['Budget']['title'];
                    $this->request->data['Note']['document_date'] = $tmpDate;
                    $this->request->data['Note']['due_date'] = date(Configure::read('dateFormatSimple'), strtotime($tmpDate . ' +' . $budget['Budget']['due_days'] . ' days'));
                    $this->request->data['Note']['note_status_id'] = '1';
                    switch ($budget['Budget']['share_periodicity_id']):
                        case 1:
                            $tmpDate = $tmpDate;
                            break;
                        case 2:
                            $tmpDate = date(Configure::read('dateFormatSimple'), strtotime($tmpDate . ' +1 year'));
                            break;
                        case 3:
                            $tmpDate = date(Configure::read('dateFormatSimple'), strtotime($tmpDate . ' +6 months'));
                            break;
                        case 4:
                            $tmpDate = date(Configure::read('dateFormatSimple'), strtotime($tmpDate . ' +3 months'));
                            break;
                        case 5:
                            $tmpDate = date(Configure::read('dateFormatSimple'), strtotime($tmpDate . ' +1 month'));
                            break;
                        case 6:
                            $tmpDate = date(Configure::read('dateFormatSimple'), strtotime($tmpDate . ' +1 week'));
                            break;
                        default:
                            break;
                    endswitch;
                    $this->_addNote();
                    if ($note['common_reserve_fund'] > 0) {
                        $this->request->data['Note']['pending_amount'] = $note['common_reserve_fund'];
                        $this->request->data['Note']['amount'] = $note['common_reserve_fund'];

                        $this->request->data['Note']['title'] = __('Common Reserve Fund') . ' ' . $shares . ' ' . __($month) . ' ' . $budget['Budget']['title'];
                        $this->_addNote();
                    }
                    $this->request->data['Note']['amount'] = $note['amount'];
                    $this->request->data['Note']['pending_amount'] = $note['amount'];

                    $shares++;
                endwhile;
            }
            $this->Flash->success(__('The notes has been created'));
            $this->redirect(array('controller' => 'budgets', 'action' => 'view', $this->getPhkRequestVar('budget_id'), '?' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));
        }

        $this->Note->Fraction->contain(array('Entity'));
        $fractions = $this->Note->Fraction->find('all', array('order' => array('Fraction.length' => 'asc', 'Fraction.fraction' => 'asc'), 'conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));
        $this->set(compact('fractions', 'budget'));
    }

    private function _addNote() {
        $this->Note->create();
        $this->request->data['Note']['fiscal_year_id'] = $this->getPhkRequestVar('fiscal_year_id');
        if ($this->Note->save($this->request->data)) {
            $this->_setDocument();
        } else {
            $this->Note->deleteAll(array('Note.budget_id' => $budget['Budget']['id']), false);
            $this->Flash->error(__('The notes could not be created. Please, try again.'));
            $this->redirect(array('action' => 'create', '?' => $this->request->query));
        }
    }

    /*private function _getFiscalYear() {
        $this->Note->Budget->id = $this->request->data['Note']['budget_id'];
        $fiscalYear = $this->Note->Budget->field('fiscal_year_id');
        return $fiscalYear;
    }*/

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

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('condo_id') || !$this->getPhkRequestVar('fiscal_year_id')) {
            $this->Flash->error(__('Invalid condo or fiscal year'));
            $this->redirect(array('controller' => 'condos', 'action' => 'index'));
        }
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo', 'Condos', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'budgets', 'action' => 'index', '?' => array('condo_id' => $this->getPhkRequestVar('condo_id')))), 'text' => __n('Budget', 'Budgets', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'budgets', 'action' => 'view', $this->getPhkRequestVar('budget_id'), '?' => array('condo_id' => $this->getPhkRequestVar('condo_id')))), 'text' => $this->getPhkRequestVar('budget_text'), 'active' => ''),
            array('link' => '', 'text' => __n('Note', 'Notes', 2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'budget_notes', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Note', 'Notes', 2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->getPhkRequestVar('note_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'budget_notes', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Note', 'Notes', 2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->getPhkRequestVar('note_text'), 'active' => 'active');
                break;
        }
        $headerTitle= __n('Note', 'Notes', 2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
