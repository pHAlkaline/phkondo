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
App::uses('Note', 'Model');

/**
 * FractionOwnersController Controller
 *
 * @property Owner $Note
 * @property PaginatorComponent $Paginator
 */
class FractionOwnersController extends AppController {

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
    public $uses = array('Fraction');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Fraction->contain('Entity');
        $fraction = $this->Fraction->find('first', array('conditions' => array('Fraction.id' => $this->Session->read('Condo.Fraction.ViewID'))));
        $this->set(compact('fraction'));
        $this->Session->delete('Condo.Owner');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Fraction->Entity->exists($id)) {
            $this->Flash->error(__('Invalid owner'));
            $this->redirect(array('action' => 'index'));
        }
        $entitiesFraction = $this->Fraction->EntitiesFraction->find('first', array('conditions' => array('EntitiesFraction.fraction_id' => $this->Session->read('Condo.Fraction.ViewID'), 'EntitiesFraction.entity_id' => $id)));
        if (count($entitiesFraction) == 0) {
            $this->Flash->error(__('The owner could not be found at this fraction. Please, try again.'));
            $this->redirect(array('controller' => 'entities', 'action' => 'view', $id));
        }

        $options = array('conditions' => array(
                'Entity.id' => $id,
        ));
        $entity = $this->Fraction->Entity->find('first', $options);

        $this->set(compact('entity', 'entitiesFraction'));
        $this->Session->write('Condo.Owner.ViewID', $id);
        $this->Session->write('Condo.Owner.ViewName', $entity['Entity']['name']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Entity']['entity_type_id'] = '1';
            $this->Fraction->Entity->create();
            if ($this->Fraction->Entity->save($this->request->data)) {
                $this->Flash->success(__('The owner has been saved'));
            } else {
                $this->Flash->error(__('The owner could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Fraction->EntitiesFraction->create();
            $this->request->data['EntitiesFraction']['fraction_id'] = $this->Session->read('Condo.Fraction.ViewID');
            $this->request->data['EntitiesFraction']['entity_id'] = $this->Fraction->Entity->id;
            $this->request->data['EntitiesFraction']['owner_percentage'] = 0;
            if ($this->Fraction->EntitiesFraction->save($this->request->data)) {
                $this->Flash->success(__('The owner has been saved and related'));
            } else {
                $this->Flash->error(__('The owner has been saved but could not be related. Please, try again.'));
            }
            $this->redirect(array('action' => 'view', $this->Fraction->Entity->id));
        }
    }

    /**
     * insert method
     *
     * @return void
     */
    public function insert() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['EntitiesFraction']['fraction_id'] = $this->Session->read('Condo.Fraction.ViewID');
            if (!isset($this->request->data['EntitiesFraction']['client'])) {
                $this->Flash->error(__('Invalid owner'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['EntitiesFraction']['entity_id'] = $this->request->data['EntitiesFraction']['client'];
            $this->Fraction->EntitiesFraction->validator()->add(
                    'owner_percentage', array(
                'valid_owner' => array(
                    'rule' => array('isUnique', array('entity_id', 'fraction_id'), false),
                    'message' => 'Invalid owner.',
            )));

            $this->Fraction->EntitiesFraction->create();
            if ($this->Fraction->EntitiesFraction->save($this->request->data)) {
                $this->Flash->success(__('The owner has been saved'));
            } else {
                 $this->Flash->error(__('The owner could not be saved. Please, try again.'));
            }
        }
        $this->redirect(array('action' => 'index'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Fraction->Entity->exists($id)) {
            $this->Flash->error(__('Invalid owner'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {


            $this->Fraction->EntitiesFraction->validator()->add(
                    'owner_percentage', array(
                'valid_percentage' => array(
                    'rule' => array('range', -0.01, 100.01),
                    'message' => 'Please enter an valid percentage.',
            )));
            if ($this->Fraction->EntitiesFraction->save($this->request->data) && $this->Fraction->Entity->save($this->request->data)) {
                $this->Flash->success(__('The owner has been saved'));
            } else {
                $this->Flash->error(__('The owner could not be saved. Please, try again.'));
            }
        }
        $options = array('conditions' => array(
                'Entity.' . $this->Fraction->Entity->primaryKey => $id,
        ));
        $fraction = $this->Fraction->Entity->find('first', $options);

        $options = array('conditions' => array(
                'EntitiesFraction.fraction_id' => $this->Session->read('Condo.Fraction.ViewID'),
                'EntitiesFraction.entity_id' => $id,
        ));
        $entitiesFraction = $this->Fraction->EntitiesFraction->find('first', $options);

        $this->Session->write('Condo.Owner.ViewID', $id);
        $this->Session->write('Condo.Owner.ViewName', $fraction['Entity']['name']);
        $this->request->data = $fraction;
        $this->request->data['EntitiesFraction'] = $entitiesFraction['EntitiesFraction'];
    }

    /**
     * current_account method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @return void
     */
    public function current_account() {
        $id = $this->Session->read('Condo.Owner.ViewID');
        $fraction_id = $this->Session->read('Condo.Fraction.ViewID');
        if (!$this->Fraction->Entity->exists($id)) {
            $this->Flash->error(__('Invalid owner'));
            $this->redirect(array('action' => 'index'));
        }
        $entitiesFraction = $this->Fraction->EntitiesFraction->find('first', array('conditions' => array('EntitiesFraction.fraction_id' => $fraction_id, 'EntitiesFraction.entity_id' => $id)));
        if (count($entitiesFraction) == 0) {
            $this->Flash->error(__('The owner could not be found at this fraction. Please, try again.'));
            $this->redirect(array('controller' => 'entities', 'action' => 'view', $id));
        }

        $event = new CakeEvent('Phkondo.FractionOwner.currentAccount', $this, array(
            'id' => $id,
            'fraction_id' => $fraction_id
        ));
        $this->getEventManager()->dispatch($event);
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function remove($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Fraction->Entity->id = $id;
        if (!$this->Fraction->Entity->exists()) {
            $this->Flash->error(__('Invalid owner'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Fraction->EntitiesFraction->deleteAll(array('EntitiesFraction.entity_id' => $id, 'EntitiesFraction.fraction_id' => $this->Session->read('Condo.Fraction.ViewID')), false)) {
            $this->Flash->success(__('Owner removed'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Owner was not removed'));
        $this->redirect(array('action' => 'view', $id));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Condo.Fraction.ViewID')) {
            $this->Flash->error(__('Invalid fraction'));
            $this->redirect(array('controller' => 'fractions', 'action' => 'index'));
        }
    }

    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo', 'Condos', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index')), 'text' => __n('Fraction', 'Fractions', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'view', $this->Session->read('Condo.Fraction.ViewID'))), 'text' => $this->Session->read('Condo.Fraction.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __n('Owner', 'Owners', 2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'fraction_owners', 'action' => 'index')), 'text' => __n('Owner', 'Owners', 2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->Session->read('Condo.Owner.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[5] = array('link' => Router::url(array('controller' => 'fraction_owners', 'action' => 'index')), 'text' => __n('Owner', 'Owners', 2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->Session->read('Condo.Owner.ViewName'), 'active' => 'active');
                break;
        }
        $headerTitle=$this->Session->read('Condo.ViewName');
        $this->set(compact('breadcrumbs','headerTitle'));
    }

    public function search_clients() {
        $this->autoRender = false;
        //$this->RequestHandler->respondAs('json');
        // get the search term from URL
        $term = $this->request->query['q'];
        $page = 1;
        //if (isset($this->request->query['page'])){
        //    $page=$this->request->query['page'];
        //}

        $fraction = $this->Fraction->find('first', array('conditions' => array('Fraction.id' => $this->Session->read('Condo.Fraction.ViewID'))));
        $entitiesInFraction = Set::extract('/Entity/id', $fraction);

        $clients = $this->Fraction->Entity->find('all', array(
            'fields' => array('Entity.id', 'Entity.name', 'Entity.address'),
            'conditions' => array(
                'Entity.name LIKE' => $term . '%',
                'Entity.entity_type_id' => '1',
                array('NOT' => array('Entity.id' => $entitiesInFraction))
            ),
            'limit' => 100,
                // 'offset' => ($page*100)-100,
        ));

        $result = array();
        foreach ($clients as $key => $client) {
            $result[$key] = $client['Entity'];
        }

        echo json_encode(array('items' => $result));
    }

}
