<?php

App::uses('AppController', 'Controller');

/**
 * OwnerNotes Controller
 *
 * @property Note $Note
 * @property PaginatorComponent $Paginator
 */
class OwnerNotesController extends AppController {

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
        $this->Note->recursive = 0;
        $this->Paginator->settings = $this->paginate + array(
            'conditions' => array(
                'Note.entity_id' => $this->Session->read('Condo.Owner.ViewID'),
                'Note.fraction_id' => $this->Session->read('Condo.Fraction.ViewID')));
        $this->setFilter(array('Note.document','Note.title','NoteType.name','Entity.name','Note.amount', 'NoteStatus.name'));
        
        $this->set('notes', $this->paginate());
        $this->Session->delete('Condo.OwnerNote');
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
                'Note.entity_id' => $this->Session->read('Condo.Owner.ViewID')));

        $note = $this->Note->find('first', $options);
        $this->set(compact('note'));
        $this->Session->write('Condo.OwnerNote.ViewID', $id);
        $this->Session->write('Condo.OwnerNote.ViewName', $note['Note']['title']);
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
            $this->request->data['Note']['entity_id'] = $this->Session->read('Condo.Owner.ViewID');
            if ($this->Note->save($this->request->data)) {
                $this->_setDocument();
                $this->Session->setFlash(__('The note has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Note->id));
            } else {
                $this->Session->setFlash(__('The note could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $noteTypes = $this->Note->NoteType->find('list');
        $fractions = $this->Note->Fraction->find('list', array('conditions' => array('Fraction.id' => $this->Session->read('Condo.Fraction.ViewID'))));
        $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('active' => '1')));
        $this->set(compact('noteTypes', 'fractions', 'noteStatuses'));
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
            $this->request->data['Note']['entity_id'] = $this->Session->read('Condo.Owner.ViewID');
            if ($this->Note->save($this->request->data)) {
                $this->Session->setFlash(__('The note has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Note->id));
            } else {
                $this->Session->setFlash(__('The note could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array(
                    'Note.' . $this->Note->primaryKey => $id,
                    'Note.entity_id' => $this->Session->read('Condo.Owner.ViewID')));

            $this->request->data = $this->Note->find('first', $options);
            if (!$this->Note->editable($this->request->data['Note'])) {
                $this->Session->setFlash(__('Invalid Note'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Note->id));
            }
        }

        $noteTypes = $this->Note->NoteType->find('list');
        $fractions = $this->Note->Fraction->find('list', array('conditions' => array('Fraction.id' => $this->Session->read('Condo.Fraction.ViewID'))));
        if ($this->request->data['Note']['receipt_id']!=null){
            $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('id' => $this->request->data['Note']['note_status_id'])));
        } else {
            $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('active' => '1')));
        }
        $this->set(compact('noteTypes', 'fractions', 'noteStatuses'));
        $this->Session->write('Condo.OwnerNote.ViewID', $id);
        $this->Session->write('Condo.OwnerNote.ViewName', $this->request->data['Note']['title']);
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

    private function _getFiscalYear() {
        $this->Note->Fraction->id = $this->request->data['Note']['fraction_id'];
        $condoId = $this->Note->Fraction->field('condo_id');
        $fiscalYear = $this->Note->FiscalYear->find('first', array('fields' => array('FiscalYear.id'), 'conditions' => array('FiscalYear.condo_id' => $condoId, 'FiscalYear.active' => '1')));
        if (isset($fiscalYear['FiscalYear']['id'])) {
            return $fiscalYear['FiscalYear']['id'];
        }

        return null;
    }

    private function _setDocument() {
        $doc_date = $this->request->data['Note']['document_date'];
        $date = new DateTime($doc_date['year'] . '-' . $doc_date['month'] . '-' . $doc_date['day']);
        $dateResult = $date->format('Y');
        $document = $this->Note->id . '-' . $this->request->data['Note']['note_type_id'];
        $this->Note->saveField('document', $document);
        return true;
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Condo.Fraction.ViewID')) {
             $this->Session->setFlash(__('Invalid fraction'), 'flash/error');
            $this->redirect(array('controller'=>'fractions','action' => 'index'));
            
        }
        
    }

    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __('Condos'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index')), 'text' => __('Fractions'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'view', $this->Session->read('Condo.Fraction.ViewID'))), 'text' => $this->Session->read('Condo.Fraction.ViewName'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fraction_owners', 'action' => 'index')), 'text' => __('Owners'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fraction_owners', 'action' => 'view', $this->Session->read('Condo.Owner.ViewID'))), 'text' => $this->Session->read('Condo.Owner.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __('Notes'), 'active' => 'active')
        );

        switch ($this->action) {
            case 'view':
                $breadcrumbs[7] = array('link' => Router::url(array('controller' => 'owner_notes', 'action' => 'index')), 'text' => __('Notes'), 'active' => '');
                $breadcrumbs[8] = array('link' => '', 'text' => $this->Session->read('Condo.OwnerNote.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[7] = array('link' => Router::url(array('controller' => 'owner_notes', 'action' => 'index')), 'text' => __('Notes'), 'active' => '');
                $breadcrumbs[8] = array('link' => '', 'text' => $this->Session->read('Condo.OwnerNote.ViewName'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }

}
