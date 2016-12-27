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
 * Entities Controller
 *
 * @property Entity $Entity
 * @property PaginatorComponent $Paginator
 */
class EntitiesController extends AppController {
    
    public $uses = array ('Entity','Maintenance');

   /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator','Feedback.Comments' => array('on' => array('view')));

     public $helpers = array(
        'Feedback.Comments' => array('elementIndex'=> 'comment_index','elementForm'=> 'comment_add')
        );
        
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings ,
                array('conditions' => array()));
        
        $this->setFilter(array('Entity.name','Entity.address','Entity.email','Entity.contacts','Entity.vat_number'));
        $this->set('entities', $this->Paginator->paginate('Entity'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Entity->exists($id)) {
            $this->Flash->error(__('Invalid entity'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Entity->contain(array('Comment','Fraction'=>array('Condo','Manager')));
        $this->Entity->bindModel(
        array(
            'hasAndBelongsToMany' => array(
                'Fraction' => array(
                    'className'              => 'Fraction',
                    'joinTable'              => 'entities_fractions',
                    'foreignKey'             => 'entity_id',
                    'associationForeignKey'  => 'fraction_id',
                    'unique'                 => true,
                    )
                )
            )
        );
        
        $options = array('conditions' => array('Entity.' . $this->Entity->primaryKey => $id));
        $entity=$this->Entity->find('first', $options);
        $this->set('entity',$entity );
        $this->setPhkRequestVar('entity_id', $id);
        $this->setPhkRequestVar('entity_text', $entity['Entity']['name']);
        
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Entity->create();
            if ($this->Entity->save($this->request->data)) {
                $this->Flash->success(__('The entity has been saved'));
                $this->redirect(array('action' => 'view',$this->Entity->id));
            } else {
                $this->Flash->error(__('The entity could not be saved. Please, try again.'));
            }
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
        if (!$this->Entity->exists($id)) {
            $this->Flash->error(__('Invalid entity'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Entity->save($this->request->data)) {
                $this->Flash->success(__('The entity has been saved'));
                $this->redirect(array('action' => 'view',$this->Entity->id));
            } else {
                $this->Flash->error(__('The entity could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Entity.' . $this->Entity->primaryKey => $id));
            $this->request->data = $this->Entity->find('first', $options);
        }
        $this->setPhkRequestVar('entity_id', $id);
        $this->setPhkRequestVar('entity_text', $this->request->data['Entity']['name']);
        
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
        $this->Entity->id = $id;
        if (!$this->Entity->exists()) {
            $this->Flash->error(__('Invalid entity'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Entity->delete()) {
            $this->Flash->success(__('Entity deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Entity can not be deleted'));
        $this->redirect(array('action' => 'view',$id));
    }

    public function beforeRender() {
        parent::beforeRender();
        if (isset($this->viewVars['breadcrumbs'])) {
            return;
        }
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => '', 'text' => __n('Entity','Entities',2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'entities', 'action' => 'index')), 'text' => __n('Entity','Entities',2), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('entity_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'entities', 'action' => 'index')), 'text' => __n('Entity','Entities',2), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('entity_text'), 'active' => 'active');
                
                break;
        }
        $headerTitle=__n('Entity','Entities',2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
