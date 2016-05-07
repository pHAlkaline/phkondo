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
class FractionEntitiesController extends AppController {

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
    public $uses = array('Entity', 'Fraction');

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
        $options = array('conditions' => array('Entity.' . $this->Entity->primaryKey => $id));
        $this->set('entity', $this->Entity->find('first', $options));
        $this->set('fractionId', $this->getPhkRequestVar('fraction_id'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($fractionId=null) {
        if ($fractionId != null && !$this->Fraction->exists($fractionId)) {
            $this->Flash->error(__('Invalid entity'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Entity->create();
            //$this->request->data['Entity']['entity_type_id'] = 1; // Client Type
            if ($this->Entity->save($this->request->data)) {
                $this->Flash->success(__('The entity has been saved'));
                if ($fractionId != null) {
                    $this->redirect(array('controller' => 'fractions', 'action' => 'edit', $fractionId));
                } else {
                    $this->redirect(array('controller' => 'fractions', 'action' => 'add'));
                }
            } else {
                $this->Flash->error(__('The entity could not be saved. Please, try again.'));
            }
        }
        $entityTypes = $this->Entity->EntityType->find('list', array('conditions' => array('id' => '1')));

        $this->set(compact('entityTypes', 'fractionId'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($fractionId=null) {
        if (!$this->Entity->exists($fractionId)) {
            $this->Flash->error(__('Invalid entity'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Entity->save($this->request->data)) {
                $this->Flash->success(__('The entity has been saved'));
                $this->redirect(array('action' => 'view', $fractionId));
            } else {
                $this->Flash->error(__('The entity could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Entity.' . $this->Entity->primaryKey => $fractionId));
            $this->request->data = $this->Entity->find('first', $options);
        }
        $entityTypes = $this->Entity->EntityType->find('list', array('conditions' => array('id' => '1')));
        $this->set(compact('entityTypes','fractionId'));
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'view', $this->getPhkRequestVar('fraction_id'))), 'text' => $this->getPhkRequestVar('fraction_text'), 'active' => ''),
            array('link' => '', 'text' => ___n('Manager','Managers',2), 'active' => 'active')
        );
        $headerTitle=___n('Manager','Managers',2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
