<?php

App::uses('AppController', 'Controller');

/**
 * BudgetNotes Controller
 *
 * @property Note $Note
 * @property PaginatorComponent $Paginator
 */
class BudgetNotesController extends AppController {

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
    public $uses = array('Note');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Note->contain('Fraction', 'NoteType', 'Entity', 'NoteStatus');
        $this->Paginator->settings = $this->paginate + array(
            'conditions' => array(
                'Note.budget_id' => $this->Session->read('Condo.Budget.ViewID')),
            'order' => array('Note.id' => 'asc', 'Note.document_date' => 'asc', 'Note.document' => 'asc'));

        $this->setFilter(array('Note.document', 'Note.title', 'NoteType.name', 'Entity.name', 'Note.amount', 'NoteStatus.name'));

        $this->set('notes', $this->paginate());
        $this->Session->delete('Condo.BudgetNotes');
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
            $this->Session->setFlash(__('Invalid note'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $this->Note->contain(array('NoteType','Fraction','Entity','Budget','FiscalYear','NoteStatus','Receipt'));
        $options = array('conditions' => array(
                'Note.' . $this->Note->primaryKey => $id,
                'Note.budget_id' => $this->Session->read('Condo.Budget.ViewID')));
        $note = $this->Note->find('first', $options);
        $this->set(compact('note'));
        $this->Session->write('Condo.BudgetNote.ViewID', $id);
        $this->Session->write('Condo.BudgetNote.ViewName', $note['Note']['title']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Note->create();
            $this->request->data['Note']['Document'] = 'null';
            $this->request->data['Note']['fiscal_year_id'] = $this->_getFiscalYear();
            if ($this->Note->save($this->request->data)) {
                $this->_setDocument();
                $this->Session->setFlash(__('The note has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Note->id));
            } else {
                $this->Session->setFlash(__('The note could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $noteTypes = $this->Note->NoteType->find('list', array('conditions' => array('NoteType.id' => '2')));
        $fractions = $this->Note->Fraction->find('list', array('order' => array('Fraction.length' => 'asc', 'Fraction.fraction' => 'asc'), 'conditions' => array('condo_id' => $this->Session->read('Condo.ViewID'))));
        $budgets = $this->Note->Budget->find('list', array('conditions' => array('id' => $this->Session->read('Condo.Budget.ViewID'))));
        //$fiscalYears = $this->Note->FiscalYear->find('list', array('conditions' => array('id' => Set::extract('/Budget/id', $budgets))));
        $entitiesFilter = $this->Note->Fraction->find('all', array('fields' => array('Fraction.id'), 'conditions' => array('condo_id' => $this->Session->read('Condo.ViewID'), 'Fraction.id' => array_keys($fractions))));
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
            $this->Session->setFlash(__('Invalid note'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Note']['fiscal_year_id'] = $this->_getFiscalYear();
            if ($this->Note->save($this->request->data)) {
                $this->_setDocument();
                $this->Session->setFlash(__('The note has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Note->id));
            } else {
                $this->Session->setFlash(__('The note could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array(
                    'Note.' . $this->Note->primaryKey => $id,
                    'Note.budget_id' => $this->Session->read('Condo.Budget.ViewID')));

            $this->request->data = $this->Note->find('first', $options);
            if (!$this->Note->editable($this->request->data['Note'])) {
                $this->Session->setFlash(__('Invalid Note'), 'flash/error');
                $this->redirect(array('action' => 'view', $this->Note->id));
            }
        }
        $noteTypes = $this->Note->NoteType->find('list');
        $fractions = $this->Note->Fraction->find('list', array('order' => array('Fraction.length' => 'asc', 'Fraction.fraction' => 'asc'), 'conditions' => array('condo_id' => $this->Session->read('Condo.ViewID'))));
        $budgets = $this->Note->Budget->find('list', array('conditions' => array('id' => $this->Session->read('Condo.Budget.ViewID'))));
        $fiscalYears = $this->Note->FiscalYear->find('list', array('conditions' => array('id' => Set::extract('/Budget/id', $budgets))));
        $entitiesFilter = $this->Note->Fraction->find('all', array('fields' => array('Fraction.id'), 'conditions' => array('condo_id' => $this->Session->read('Condo.ViewID')))); //'Fraction.id' => $this->request->data['Note']['fraction_id']
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
            $this->Session->setFlash(__('Invalid note'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Note->delete()) {
            $this->Session->setFlash(__('Note deleted'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Note can not be deleted'), 'flash/error');
        $this->redirect(array('action' => 'view', $id));
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
      
        $budget = $this->Note->Budget->find('first', array('conditions' => array('Budget.id' => $this->Session->read('Condo.Budget.ViewID'), 'Budget.budget_status_id' => '2')));
        if (isset($budget['Note']) && count($budget['Note']) > 0) {
            $this->Session->setFlash(__('Invalid Budget'), 'flash/success');
            $this->redirect(array('controller' => 'budgets', 'action' => 'index'));
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
                    $this->request->data['Note']['title'] = __n('Share','Shares',1) . ' ' . $shares . ' ' . __($month) . ' ' . $budget['Budget']['title'];
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
            $this->Session->setFlash(__('The notes has been created'), 'flash/success');
            $this->redirect(array('controller' => 'budgets', 'action' => 'view', $this->Session->read('Condo.Budget.ViewID')));
        }

        $this->Note->Fraction->contain(array('Entity'));
        $fractions = $this->Note->Fraction->find('all', array('order' => array('Fraction.length' => 'asc', 'Fraction.fraction' => 'asc'), 'conditions' => array('condo_id' => $this->Session->read('Condo.ViewID'))));
        $this->set(compact('fractions', 'budget'));
    }

    private function _addNote() {
        $this->Note->create();
        $this->request->data['Note']['Document'] = 'null';
        $this->request->data['Note']['fiscal_year_id'] = $this->_getFiscalYear();
        if ($this->Note->save($this->request->data)) {
           $this->_setDocument();
            
        } else {
            $this->Note->deleteAll(array('Note.budget_id' => $budget['Budget']['id']), false);
            $this->Session->setFlash(__('The notes could not be created. Please, try again.'), 'flash/error');
            $this->redirect(array('action' => 'create'));
        }
    }

    private function _getFiscalYear() {
        $this->Note->Budget->id = $this->request->data['Note']['budget_id'];
        $fiscalYear = $this->Note->Budget->field('fiscal_year_id');
        return $fiscalYear;
    }

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
        if (!$this->Session->check('Condo.ViewID') || !$this->Session->read('Condo.FiscalYearID')) {
            $this->Session->setFlash(__('Invalid condo or fiscal year'), 'flash/error');
            $this->redirect(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID')));
        }
    }

    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'budgets', 'action' => 'index')), 'text' => __n('Budget','Budgets',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'budgets', 'action' => 'view', $this->Session->read('Condo.Budget.ViewID'))), 'text' => $this->Session->read('Condo.Budget.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __('Notes'), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'budget_notes', 'action' => 'index')), 'text' => __('Notes'), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->Session->read('Condo.BudgetNote.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'budget_notes', 'action' => 'index')), 'text' => __('Notes'), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->Session->read('Condo.BudgetNote.ViewName'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }

}
