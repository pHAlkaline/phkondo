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
 * Fractions Controller
 *
 * @property Fraction $Fraction
 * @property PaginatorComponent $Paginator
 */
class FractionsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Paginator', 
        'Feedback.Comments' => array('on' => array('view'))
        );

     public $helpers = array(
        'Feedback.Comments' => array('elementIndex'=> 'comment_index','elementForm'=> 'comment_add')
        );
        
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings , array(
            'contain' => array('Entity', 'Manager','FractionType'),
            'conditions' => array('Fraction.condo_id' => $this->getPhkRequestVar('condo_id')),
            'limit'=>100000,
            'maxLimit'=>100000
        ));
        
        $this->setFilter(array('Fraction.fraction', 'Fraction.floor_location', 'Fraction.description', 'Fraction.mil_rate', 'Manager.name', 'FractionType.name'));
        $fractions = $this->Paginator->paginate('Fraction');
        $milRateWarning=false;
        $milRate = Set::extract('/Fraction/mil_rate', $fractions);
        if ($this->Session->read('Condo.'.$this->getPhkRequestVar('condo_id').'.Fraction.milrate')!='show' && array_sum($milRate) != 1000 && array_sum($milRate) != 0){
            $this->Session->write('Condo.'.$this->getPhkRequestVar('condo_id').'.Fraction.milrate','show');
            $milRateWarning=true;
        }
            
        $this->set(compact('fractions', 'milRateWarning'));
        
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Fraction->exists($id)) {
            $this->Flash->error(__('Invalid fraction'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Fraction->contain('Manager', 'Comment','FractionType');
        $options = array('conditions' => array('Fraction.id' => $id));
        $fraction = $this->Fraction->find('first', $options);
        $this->set(compact('fraction'));
        $this->setPhkRequestVar('fraction_id', $id);
        
        
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Fraction->create();
            if ($this->Fraction->save($this->request->data)) {
                $this->Flash->success(__('The fraction has been saved'));
                $this->Session->delete('Condo.'.$this->getPhkRequestVar('condo_id').'.Fraction.milrate');
                $this->redirect(array('action' => 'view', $this->Fraction->id, '?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The fraction could not be saved. Please, try again.'));
            }
        }
        $condos = $this->Fraction->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $fractionTypes = $this->Fraction->FractionType->find('list', array('conditions' => array('active' =>'1')));
        $this->set(compact('condos', 'fractionTypes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Fraction->exists($id)) {
            $this->Flash->error(__('Invalid fraction'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Fraction->save($this->request->data)) {
                $this->Flash->success(__('The fraction has been saved'));
                $this->Session->delete('Condo.'.$this->getPhkRequestVar('condo_id').'.Fraction.milrate');
                $this->redirect(array('action' => 'view', $id, '?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The fraction could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Fraction.id' => $id));
            $this->request->data = $this->Fraction->find('first', $options);
        }
        $condos = $this->Fraction->Condo->find('list', array('conditions' => array('Condo.id' => $this->request->data['Fraction']['condo_id'])));

        $this->setPhkRequestVar('fraction_id', $id);
        
        
        $this->Fraction->contain('Entity');
        $fraction = $this->Fraction->find('first', array('conditions' => array('Fraction.id'=>$id)));
        $entitiesInFraction = Set::extract('/Entity/id', $fraction);

        $managers = $this->Fraction->Manager->find('list', array('order' => 'Manager.name', 'conditions' => array('Manager.id' => $entitiesInFraction)));
        $fractionTypes = $this->Fraction->FractionType->find('list', array('conditions' => array('active' =>'1')));
        
        $this->set(compact('condos', 'managers', 'fractionTypes'));
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
        $this->Fraction->id = $id;
        if (!$this->Fraction->exists()) {
            $this->Flash->error(__('Invalid fraction'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }

        if (!$this->Fraction->deletable()) {
            $this->Flash->error(__('This Fraction can not be deleted, check existing notes already paid.'));
            $this->redirect(array('action' => 'view', $id,'?'=>$this->request->query));
        }

        ClassRegistry::init('Note')->DeleteAll(array('Note.fraction_id' => $id));
        ClassRegistry::init('Receipt')->DeleteAll(array('Receipt.fraction_id' => $id));
        ClassRegistry::init('Insurance')->DeleteAll(array('Insurance.fraction_id' => $id));

        if ($this->Fraction->delete()) {
            $this->Flash->success(__('Fraction deleted'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Flash->error(__('Fraction can not be deleted'));
        $this->redirect(array('action' => 'view', $id,'?'=>$this->request->query));
    }
    
    /**
     * current_account method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @return void
     */
    public function current_account() {
        $id = $this->getPhkRequestVar('fraction_id');
        if (!$this->Fraction->exists($id)) {
            $this->Flash->error(__('Invalid fraction'));
            $this->redirect(array('action' => 'index', '?'=>$this->request->query));
        }
        $event = new CakeEvent('Phkondo.Fraction.currentAccount', $this, array(
            'id' => $id,
        ));
        $this->getEventManager()->dispatch($event);
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
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo', 'Condos', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view',$this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => '', 'text' => __n('Fraction', 'Fractions', 2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Fraction', 'Fractions', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('fraction_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Fraction', 'Fractions', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('fraction_text'), 'active' => 'active');
                break;
        }
        $headerTitle=__n('Fraction', 'Fractions', 2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
