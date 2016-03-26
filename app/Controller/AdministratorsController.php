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
App::uses('Fraction', 'Model');

/**
 * Administrators Controller
 *
 * @property Administrator $Administrator
 * @property PaginatorComponent $Paginator
 */
class AdministratorsController extends AppController {

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
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings , array(
            'contain'=>array('Entity','FiscalYear'),
            'conditions' => array(
                'Administrator.condo_id' => $this->getPhkRequestVar('condo_id'),
                'Administrator.fiscal_year_id' => $this->getPhkRequestVar('fiscal_year_id'))
        ));
        $this->setFilter(array('Administrator.title','Entity.name','Entity.email','Entity.representative','FiscalYear.title'));
        $this->set('administrators', $this->Paginator->paginate('Administrator'));
        
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Administrator->exists($id)) {
            $this->Flash->error(__('Invalid administrator'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Administrator->contain('Entity','FiscalYear');
        $options = array('conditions' => array('Administrator.' . $this->Administrator->primaryKey => $id,
                'Administrator.condo_id' => $this->getPhkRequestVar('condo_id'),
                'Administrator.fiscal_year_id' => $this->getPhkRequestVar('fiscal_year_id')));
        $administrator=$this->Administrator->find('first', $options);
        $this->set('administrator', $administrator);
        $this->setPhkRequestVar('administrator_id',$id);
       
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Administrator->create();
            if ($this->Administrator->save($this->request->data)) {
                $this->Flash->success(__('The administrator has been saved'));
                $this->redirect(array('action' => 'view',$this->Administrator->id,'?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The administrator could not be saved. Please, try again.'));
            }
        }
        $this->Administrator->contain('Entity','FiscalYear');
        
        $condos = $this->Administrator->Condo->find('list', array('conditions' => array('id' =>  $this->getPhkRequestVar('condo_id'))));
        
        $this->Administrator->contain('Entity','FiscalYear');
        $options = array('conditions' => array(
                'Administrator.condo_id' => $this->getPhkRequestVar('condo_id'),
                'Administrator.fiscal_year_id' => $this->getPhkRequestVar('fiscal_year_id')));
        $administrators=$this->Administrator->find('all', $options);
        
        $this->Fraction = $this->Administrator->Condo->Fraction;
        $this->Fraction->contain('Entity');
        $this->Fraction->noAfterFind=true;
        $fractions = $this->Fraction->find('all', array('conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));
        $entities = $this->Administrator->Entity->find('list', array('conditions' => array('id' => Set::extract('/Entity/id', $fractions),'NOT'=>array('id'=>Set::extract('/Entity/id', $administrators)))));
        $fiscalYears = $this->Administrator->FiscalYear->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('fiscal_year_id'))));
        $this->set(compact('condos', 'entities', 'fiscalYears'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Administrator->exists($id)) {
            $this->Flash->error(__('Invalid administrator'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Administrator->contain('Entity');
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Administrator->save($this->request->data)) {
                $this->Flash->success(__('The administrator has been saved'));
                $this->redirect(array('action' => 'view',$this->Administrator->id,'?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The administrator could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Administrator.' . $this->Administrator->primaryKey => $id));
            $this->request->data = $this->Administrator->find('first', $options);
        }
        $condos = $this->Administrator->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $options = array('conditions' => array(
                'Administrator.id <>' => $id,
                'Administrator.condo_id' => $this->getPhkRequestVar('condo_id'),
                'Administrator.fiscal_year_id' => $this->getPhkRequestVar('fiscal_year_id')));
        $administrators=$this->Administrator->find('all', $options);
        
        $this->Fraction = $this->Administrator->Condo->Fraction;
        $this->Fraction->contain('Entity');
        $this->Fraction->noAfterFind=true;
        $fractions = $this->Fraction->find('all', array('conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));
        
        $entities = $this->Administrator->Entity->find('list', array('conditions' => array('id' => Set::extract('/Entity/id', $fractions),'NOT'=>array('id'=>Set::extract('/Entity/id', $administrators)))));
        $fiscalYears = $this->Administrator->FiscalYear->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('fiscal_year_id'))));
        
        $this->set(compact('condos', 'entities', 'fiscalYears'));
        $this->setPhkRequestVar('administrator_id',$id);
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
        $this->Administrator->id = $id;
        if (!$this->Administrator->exists()) {
            $this->Flash->error(__('Invalid administrator'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        if ($this->Administrator->delete()) {
            $this->Flash->success(__('Administrator deleted'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Flash->error(__('Administrator can not be deleted'));
        $this->redirect(array('action' => 'view',$id,'?'=>$this->request->query));
    }
    
    
    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('condo_id') || !$this->getPhkRequestVar('fiscal_year_id')) {
            $this->Flash->error(__('Invalid condo or fiscal year'));
            $this->redirect(array('controller'=>'condos','action' => 'index'));
        }
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo', 'Condos', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view',$this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => '', 'text' => __n('Administrator','Administrators',2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                 $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'administrators', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Administrator','Administrators',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('administrator_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'administrators', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Administrator','Administrators',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('administrator_text'), 'active' => 'active');
                break;
        }
        $headerTitle=__n('Administrator','Administrators',2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }


}
