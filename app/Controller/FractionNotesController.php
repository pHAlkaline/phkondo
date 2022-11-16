<?php

/**
 *
 * pHKondo : pHKondo software for condominium property managers (http://phalkaline.net)
 * Copyright (c) pHAlkaline . (http://phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (http://phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
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
        $this->setConditions();
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings, array(
            'conditions' => array('Note.fraction_id' => $this->getPhkRequestVar('fraction_id')),
            //'requiresAcessLevel' => true,
            'contain' => array('NoteType', 'Entity', 'NoteStatus')
        ));
        $this->setFilter(array('Note.document', 'Note.title', 'NoteType.name', 'Entity.name', 'Note.amount', 'NoteStatus.name'));
        $this->set('notes', $this->Paginator->paginate('Note'));
    }

    private function setConditions() {
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
        $noteStatuses = $this->Note->NoteStatus->find('list', array('order' => 'name', 'conditions' => array('active' => 1)));

        if (isset($queryData['entity_id']) && $queryData['entity_id'] != null) {
            $entity_id = $queryData['entity_id'];
            $filterOptions['conditions'] = array_merge($filterOptions['conditions'], array('Note.entity_id' => $entity_id));
            $this->request->data['Note']['entity_id'] = $queryData['entity_id'];
            $hasAdvSearch = true;
        }

        $this->Note->contain(array('Entity' => array('fields' => array('Entity.id'))));
        $entitiesFilter = $this->Note->find('all', array('fields' => array('Note.id'), 'conditions' => array('fraction_id' => $this->getPhkRequestVar('fraction_id'))));
        $entities = $this->Note->Entity->find('list', array('conditions' => array('id' => Set::extract('/Entity/id', $entitiesFilter))));
        $this->set(compact('noteStatuses', 'entities', 'hasAdvSearch'));


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
    public function view($id = null) {
        if (!$this->Note->exists($id)) {
            $this->Flash->error(__('Invalid note'));
            $this->redirect(array('action' => 'index', '?' => $this->request->query));
        }
        $this->Note->contain(array('NoteType', 'Entity', 'Fraction', 'Budget', 'FiscalYear', 'NoteStatus', 'Receipt'));
        $options = array('conditions' => array(
                'Note.' . $this->Note->primaryKey => $id,
                'Note.fraction_id' => $this->getPhkRequestVar('fraction_id')));

        $note = $this->Note->find('first', $options);
        $this->set('note', $note);
        $this->setPhkRequestVar('note_id', $id);
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
        $noteTypes = $this->Note->NoteType->find('list');
        $fractions = $this->Note->Fraction->find('list', array('conditions' => array('Fraction.id' => $this->getPhkRequestVar('fraction_id'))));
        //debug($fractions);   
        $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('active' => '1')));
        $this->Note->Fraction->contain('Entity');
        $entitiesFilter = $this->Note->Fraction->find('all', array('fields' => array('Fraction.id'), 'conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'), 'Fraction.id' => array_keys($fractions))));
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
                    'Note.fraction_id' => $this->getPhkRequestVar('fraction_id')));

            $this->request->data = $this->Note->find('first', $options);
            if (!$this->Note->editable($this->request->data['Note'])) {
                $this->Flash->error(__('Invalid Request'));
                $this->redirect(array('action' => 'index', '?' => $this->request->query));
            }
        }


        $noteTypes = $this->Note->NoteType->find('list');
        $fractions = $this->Note->Fraction->find('list', array('conditions' => array('Fraction.id' => $this->request->data['Note']['fraction_id'])));

        if (isset($this->request->data['Note']['receipt_id']) && $this->request->data['Note']['receipt_id'] != null) {
            $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('id' => $this->request->data['Note']['note_status_id'])));
        } else {
            $noteStatuses = $this->Note->NoteStatus->find('list', array('conditions' => array('active' => '1')));
        }
        $this->Note->Fraction->contain('Entity');
        $entitiesFilter = $this->Note->Fraction->find('all', array('fields' => array('Fraction.id'), 'conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'), 'Fraction.id' => array_keys($fractions))));
        $entities = $this->Note->Entity->find('list', array('conditions' => array('id' => Set::extract('/Entity/id', $entitiesFilter))));
        $this->set(compact('noteTypes', 'fractions', 'noteStatuses', 'entities'));
        $this->setPhkRequestVar('note_id', $id);
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

    /* private function _getFiscalYear() {
      $this->Note->Fraction->id = $this->request->data['Note']['fraction_id'];
      $condoId = $this->Note->Fraction->field('condo_id');
      $fiscalYear = $this->Note->FiscalYear->find('first', array('fields' => array('FiscalYear.id'), 'conditions' => array('FiscalYear.condo_id' => $condoId, 'FiscalYear.active' => '1')));
      if (isset($fiscalYear['FiscalYear']['id'])) {
      return $fiscalYear['FiscalYear']['id'];
      }

      return null;
      } */

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
        if (!$this->getPhkRequestVar('condo_id')) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('controller' => 'condos', 'action' => 'index'));
        }
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text') . ' ( ' . $this->phkRequestData['fiscal_year_text'] . ' ) ', 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index', '?' => array('condo_id' => $this->getPhkRequestVar('condo_id')))), 'text' => __n('Fraction', 'Fractions', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'view', $this->getPhkRequestVar('fraction_id'), '?' => array('condo_id' => $this->getPhkRequestVar('condo_id')))), 'text' => $this->getPhkRequestVar('fraction_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fraction_notes', 'action' => 'index', '?' => $this->request->query), true), 'text' => __n('Note', 'Notes', 2), 'active' => 'active')
        );

        switch ($this->action) {
            case 'view':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'fraction_notes', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Note', 'Notes', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('note_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'fraction_notes', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Note', 'Notes', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('note_text'), 'active' => 'active');
                break;
        }
        $headerTitle = __n('Note', 'Notes', 2);
        $this->set(compact('breadcrumbs', 'headerTitle'));
    }

}
