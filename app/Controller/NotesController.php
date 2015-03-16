<?php

App::uses('AppController', 'Controller');

/**
 * Notes Controller
 *
 * @property Note $Note
 * @property PaginatorComponent $Paginator
 */
class NotesController extends AppController {

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
        $this->Note->recursive = 0;
        $this->Paginator->settings = $this->paginate + array(
            'conditions' => array(
                'Note.budget_id' => $this->Session->read('Condo.Budget.ViewID')));
        $this->set('notes', $this->paginate());
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
        $options = array('conditions' => array(
                'Note.' . $this->Note->primaryKey => $id,
                'Note.budget_id' => $this->Session->read('Condo.Budget.ViewID')));

        $this->set('note', $this->Note->find('first', $options));
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
            if ($this->Note->save($this->request->data)) {
                $this->_setEntity();
                $this->_setFiscalYear();
                $this->_setDocument();
                $this->Session->setFlash(__('The note has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Note->id));
            } else {
                $this->Session->setFlash(__('The note could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $noteTypes = $this->Note->NoteType->find('list', array('conditions' => array('NoteType.id' => '2')));
        $fractions = $this->Note->Fraction->find('list', array('conditions' => array('condo_id' => $this->Session->read('Condo.ViewID'))));
        $budgets = $this->Note->Budget->find('list', array('conditions' => array('id' => $this->Session->read('Condo.Budget.ViewID'))));
        $fiscalYears = $this->Note->FiscalYear->find('list', array('conditions' => array('id' => Set::extract('/Budget/id', $budgets))));
        $entities = $this->Note->Entity->find('list', array('conditions' => array('id' => Set::extract('/Fraction/id', $fractions))));

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
            if ($this->Note->save($this->request->data)) {
                $this->_setEntity();
                $this->_setFiscalYear();
                $this->Session->setFlash(__('The note has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Session->setFlash(__('The note could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array(
                    'Note.' . $this->Note->primaryKey => $id,
                    'Note.budget_id' => $this->Session->read('Condo.Budget.ViewID')));

            $this->request->data = $this->Note->find('first', $options);
            if (!$this->Note->editable($this->request->data['Note'])) {
                $this->Session->setFlash(__('Invalid note'), 'flash/error');
            $this->redirect(array('action' => 'index'));
            }
        }
        $noteTypes = $this->Note->NoteType->find('list');
        $fractions = $this->Note->Fraction->find('list', array('conditions' => array('condo_id' => $this->Session->read('Condo.ViewID'))));

        $budgets = $this->Note->Budget->find('list', array('conditions' => array('id' => $this->Session->read('Condo.Budget.ViewID'))));
        $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('active' => '1')));
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
        $budget = $this->Note->Budget->find('first', array('conditions' => array('Budget.id' => $this->Session->read('Condo.Budget.ViewID'))));
        if (count($budget['Note']) > 0) {
            $this->Session->setFlash(__('Invalid Budget'), 'flash/error');
            $this->redirect(array('controller'=>'budgets','action' => 'index'));
        }
        if ($this->request->is('post')) {
            $notes = $this->request->data['Note'];
            //debug('+' . $budget['Budget']['due_days'] . ' days');

            unset($notes['Budget']);
            foreach ($notes as $key => $note) {
                // check fraction please
                $this->request->data['Note'] = $note;
                $this->request->data['Note']['budget_id'] = $budget['Budget']['id'];
                $this->request->data['Note']['note_type_id'] = '2';
                $this->request->data['Note']['pending_amount'] = $note['amount'];
                $shares = 1;
                $tmpDate = $budget['Budget']['begin_date'];
                while ($shares <= $note['shares']):
                    $this->request->data['Note']['title'] = __('Share ') . $shares . ' ' . $budget['Budget']['title'];
                    $this->request->data['Note']['document_date'] = $tmpDate;
                    $this->request->data['Note']['due_date'] = date('Y-m-d', strtotime($tmpDate . ' +' . $budget['Budget']['due_days'] . ' days'));
                    $this->request->data['Note']['note_status_id'] = '1';
                    switch ($budget['Budget']['share_periodicity_id']):
                        case 1:
                            $tmpDate = $tmpDate;
                            break;
                        case 2:
                            $tmpDate = date('Y-m-d', strtotime($tmpDate . ' +1 year'));
                            break;
                        case 3:
                            $tmpDate = date('Y-m-d', strtotime($tmpDate . ' +6 months'));
                            break;
                        case 4:
                            $tmpDate = date('Y-m-d', strtotime($tmpDate . ' +3 months'));
                            break;
                        case 5:
                            $tmpDate = date('Y-m-d', strtotime($tmpDate . ' +1 month'));
                            break;
                        case 6:
                            $tmpDate = date('Y-m-d', strtotime($tmpDate . ' +1 week'));
                            break;
                        default:
                            break;
                    endswitch;
                    $this->Note->create();
                    $this->request->data['Note']['Document'] = 'null';
                    if ($this->Note->save($this->request->data)) {
                        $this->_setEntity();
                        $this->_setFiscalYear();
                        $this->_setDocument();
                        //$this->Session->setFlash(__('The note has been saved'), 'flash/success');
                    } else {
                        $this->Note->deleteAll(array('Note.budget_id' => $budget['Budget']['id']), false);
                        $this->Session->setFlash(__('The notes could not be created. Please, try again.'), 'flash/error');
                    }
                    $shares++;
                endwhile;
            }
            $this->Session->setFlash(__('The notes has been created'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }

        $fractions = $this->Note->Fraction->find('all', array('conditions' => array('condo_id' => $this->Session->read('Condo.ViewID'))));
        $this->set(compact('fractions', 'budget'));
    }

    private function _setEntity() {
        $this->Note->Fraction->id = $this->request->data['Note']['fraction_id'];
        $entity = $this->Note->Fraction->field('manager_id');
        $this->Note->saveField('entity_id', $entity);
        return true;
    }

    private function _setFiscalYear() {
        $this->Note->Budget->id = $this->request->data['Note']['budget_id'];
        $fiscalYear = $this->Note->Budget->field('fiscal_year_id');
        $this->Note->saveField('fiscal_year_id', $fiscalYear);
        return true;
    }

    private function _setDocument() {
        $date = new DateTime($this->request->data['Note']['document_date']);
        $dateResult = $date->format('Y');
        $document = $this->Note->id . '-' . $this->request->data['Note']['note_type_id'];
        $this->Note->saveField('document', $document);
        return true;
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Condo.Budget.ViewID')) {
            $this->Session->setFlash(__('Invalid budget'), 'flash/error');
            $this->redirect(array('controller' => 'budgets', 'action' => 'index'));
        }
        if ($this->Session->read('Condo.Budget.Status') > 1 && in_array($this->action, array('add', 'edit', 'delete', 'create'))) {
            $this->Session->setFlash(__('Invalid budget'), 'flash/error');
            $this->redirect(array('controller' => 'budgets', 'action' => 'index'));
        }
    }

    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __('Condos'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'budgets', 'action' => 'index')), 'text' => __('Budgets'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'budgets', 'action' => 'view', $this->Session->read('Condo.Budget.ViewID'))), 'text' => $this->Session->read('Condo.Budget.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __('Notes'), 'active' => 'active')
        );
        $this->set(compact('breadcrumbs'));
    }

}
