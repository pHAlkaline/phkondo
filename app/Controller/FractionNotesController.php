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
 * FractionNotes Controller
 *
 * @property Note $Note
 * @property PaginatorComponent $Paginator
 */
class FractionNotesController extends AppController {

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
        $this->Note->contain(array('NoteType','Entity','NoteStatus'));
        $this->Paginator->settings = $this->paginate + array(
            'conditions' => array(
                'Note.fraction_id' => $this->Session->read('Condo.Fraction.ViewID')));
        $this->setFilter(array('Note.document','Note.title','NoteType.name','Entity.name','Note.amount', 'NoteStatus.name'));
        
        $this->set('notes', $this->paginate());
        $this->Session->delete('Condo.FractionNote');
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
            $this->redirect(array('action' => 'index'));
        }
        $this->Note->contain(array('NoteType','Entity','Fraction','Budget','FiscalYear','NoteStatus','Receipt'));
        $options = array('conditions' => array(
                'Note.' . $this->Note->primaryKey => $id,
                'Note.fraction_id' => $this->Session->read('Condo.Fraction.ViewID')));

        $note = $this->Note->find('first', $options);
        $this->set('note', $note);
        $this->Session->write('Condo.FractionNote.ViewID', $id);
        $this->Session->write('Condo.FractionNote.ViewName', $note['Note']['title']);
        
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
                $this->Flash->success(__('The note has been saved'));
                $this->redirect(array('action' => 'view', $this->Note->id));
            } else {
                $this->Flash->error(__('The note could not be saved. Please, try again.'));
            }
        }
        $noteTypes = $this->Note->NoteType->find('list');
        $fractions = $this->Note->Fraction->find('list', array('conditions' => array('Fraction.id' => $this->Session->read('Condo.Fraction.ViewID'))));
        $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('active' => '1')));
        $this->Note->Fraction->contain('Entity');
        $entitiesFilter = $this->Note->Fraction->find('all', array('fields' => array('Fraction.id'), 'conditions' => array('condo_id' => $this->Session->read('Condo.ViewID'), 'Fraction.id' => array_keys($fractions))));
        $entities = $this->Note->Entity->find('list', array('conditions' => array('id' => Set::extract('/Entity/id', $entitiesFilter))));
        $this->set(compact('noteTypes', 'fractions', 'noteStatuses', 'entities'));
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
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Note']['fiscal_year_id'] = $this->_getFiscalYear();
            if ($this->Note->save($this->request->data)) {
                $this->_setDocument();
                $this->Flash->success(__('The note has been saved'));
                $this->redirect(array('action' => 'view', $this->Note->id));
            } else {
                $this->Flash->error(__('The note could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array(
                    'Note.' . $this->Note->primaryKey => $id,
                    'Note.fraction_id' => $this->Session->read('Condo.Fraction.ViewID')));

            $this->request->data = $this->Note->find('first', $options);
            if (!$this->Note->editable($this->request->data['Note'])) {
                $this->Flash->success(__('Invalid Note'));
                $this->redirect(array('action' => 'view', $this->Note->id));
            }
        }


        $noteTypes = $this->Note->NoteType->find('list');
        $fractions = $this->Note->Fraction->find('list', array('conditions' => array('Fraction.id' => $this->Session->read('Condo.Fraction.ViewID'))));

         if (isset($this->request->data['Note']['receipt_id']) && $this->request->data['Note']['receipt_id']!=null){
            $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('id' => $this->request->data['Note']['note_status_id'])));
        } else {
            $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('active' => '1')));
        }
        $this->Note->Fraction->contain('Entity');
        $entitiesFilter = $this->Note->Fraction->find('all', array('fields' => array('Fraction.id'), 'conditions' => array('condo_id' => $this->Session->read('Condo.ViewID'), 'Fraction.id' => array_keys($fractions))));
        $entities = $this->Note->Entity->find('list', array('conditions' => array('id' => Set::extract('/Entity/id', $entitiesFilter))));
        $this->set(compact('noteTypes', 'fractions', 'noteStatuses', 'entities'));
        $this->Session->write('Condo.FractionNote.ViewID', $id);
        $this->Session->write('Condo.FractionNote.ViewName', $this->request->data['Note']['title']);
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
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Note->delete()) {
            $this->Flash->success(__('Note deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Note can not be deleted'));
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
         if (is_array($this->request->data['Note']['document_date'])) {
            $dateTmp = $this->request->data['Note']['document_date']['day'] . '-' . $this->request->data['Note']['document_date']['month'] . '-' . $this->request->data['Note']['document_date']['year'];
            $this->request->data['Note']['document_date'] = $dateTmp;
        };
        $date = new DateTime($this->request->data['Note']['document_date']);
        $dateResult = $date->format('Y');
        $document = $this->Note->id . '-' . $this->request->data['Note']['note_type_id'];
        $this->Note->saveField('document', $document);
        return true;
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Condo.Fraction.ViewID')) {
            $this->Flash->error(__('Invalid fraction'));
            $this->redirect(array('controller'=>'fractions','action' => 'index'));
        }
    }

    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index')), 'text' => __n('Fraction','Fractions',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'view', $this->Session->read('Condo.Fraction.ViewID'))), 'text' => $this->Session->read('Condo.Fraction.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __('Notes'), 'active' => 'active')
        );
        
        switch ($this->action) {
            case 'view':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'fraction_notes', 'action' => 'index')), 'text' => __('Notes'), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->Session->read('Condo.FractionNote.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'fraction_notes', 'action' => 'index')), 'text' => __('Notes'), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->Session->read('Condo.FractionNote.ViewName'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }

}
