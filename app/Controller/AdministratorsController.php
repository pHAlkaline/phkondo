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
        $this->Administrator->contain('Entity','FiscalYear');
        $this->Paginator->settings = $this->paginate + array(
            'conditions' => array(
                'Administrator.condo_id' => $this->Session->read('Condo.ViewID'),
                'Administrator.fiscal_year_id' => $this->Session->read('Condo.FiscalYearID'))
        );
        $this->setFilter(array('Administrator.title','Entity.name','Entity.email','Entity.representative'));
        $this->set('administrators', $this->paginate());
        $this->Session->delete('Condo.Administrator');
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
            $this->redirect(array('action' => 'index'));
        }
        $this->Administrator->contain('Entity','FiscalYear');
        $options = array('conditions' => array('Administrator.' . $this->Administrator->primaryKey => $id,
                'Administrator.condo_id' => $this->Session->read('Condo.ViewID'),
                'Administrator.fiscal_year_id' => $this->Session->read('Condo.FiscalYearID')));
        $administrator=$this->Administrator->find('first', $options);
        $this->set('administrator', $administrator);
        $this->Session->write('Condo.Administrator.ViewID', $id);
        $this->Session->write('Condo.Administrator.ViewName', $administrator['Entity']['name']);
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
                $this->redirect(array('action' => 'view',$this->Administrator->id));
            } else {
                $this->Flash->error(__('The administrator could not be saved. Please, try again.'));
            }
        }
        $this->Administrator->contain('Entity','FiscalYear');
        
        $condos = $this->Administrator->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        
        $this->Administrator->contain('Entity','FiscalYear');
        $options = array('conditions' => array(
                'Administrator.condo_id' => $this->Session->read('Condo.ViewID'),
                'Administrator.fiscal_year_id' => $this->Session->read('Condo.FiscalYearID')));
        $administrators=$this->Administrator->find('all', $options);
        
        $this->Fraction = $this->Administrator->Condo->Fraction;
        $this->Fraction->contain('Entity');
        $this->Fraction->noAfterFind=true;
        $fractions = $this->Fraction->find('all', array('conditions' => array('condo_id' => $this->Session->read('Condo.ViewID'))));
        $entities = $this->Administrator->Entity->find('list', array('conditions' => array('id' => Set::extract('/Entity/id', $fractions),'NOT'=>array('id'=>Set::extract('/Entity/id', $administrators)))));
        $fiscalYears = $this->Administrator->FiscalYear->find('list', array('conditions' => array('id' => $this->Session->read('Condo.FiscalYearID'))));
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
            $this->redirect(array('action' => 'index'));
        }
        $this->Administrator->contain('Entity');
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Administrator->save($this->request->data)) {
                $this->Flash->success(__('The administrator has been saved'));
                $this->redirect(array('action' => 'view',$this->Administrator->id));
            } else {
                $this->Flash->error(__('The administrator could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Administrator.' . $this->Administrator->primaryKey => $id));
            $this->request->data = $this->Administrator->find('first', $options);
        }
        $condos = $this->Administrator->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $options = array('conditions' => array(
                'Administrator.id <>' => $id,
                'Administrator.condo_id' => $this->Session->read('Condo.ViewID'),
                'Administrator.fiscal_year_id' => $this->Session->read('Condo.FiscalYearID')));
        $administrators=$this->Administrator->find('all', $options);
        
        $this->Fraction = $this->Administrator->Condo->Fraction;
        $this->Fraction->contain('Entity');
        $this->Fraction->noAfterFind=true;
        $fractions = $this->Fraction->find('all', array('conditions' => array('condo_id' => $this->Session->read('Condo.ViewID'))));
        
        $entities = $this->Administrator->Entity->find('list', array('conditions' => array('id' => Set::extract('/Entity/id', $fractions),'NOT'=>array('id'=>Set::extract('/Entity/id', $administrators)))));
        $fiscalYears = $this->Administrator->FiscalYear->find('list', array('conditions' => array('id' => $this->Session->read('Condo.FiscalYearID'))));
        
        $this->set(compact('condos', 'entities', 'fiscalYears'));
        $this->Session->write('Condo.Administrator.ViewID', $id);
        $this->Session->write('Condo.Administrator.ViewName', $this->request->data['Entity']['name']);
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
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Administrator->delete()) {
            $this->Flash->success(__('Administrator deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Administrator can not be deleted'));
        $this->redirect(array('action' => 'view',$id));
    }
    
    
    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Condo.ViewID') || !$this->Session->read('Condo.FiscalYearID')) {
            $this->Flash->error(__('Invalid condo or fiscal year'));
            $this->redirect(array('controller'=>'condos','action' => 'view',$this->Session->read('Condo.ViewID')));
        }
    }

    public function beforeRender() {



        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __n('Administrator','Administrators',2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                 $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'administrators', 'action' => 'index')), 'text' => __n('Administrator','Administrators',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->Session->read('Condo.Administrator.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'administrators', 'action' => 'index')), 'text' => __n('Administrator','Administrators',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->Session->read('Condo.Administrator.ViewName'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }


}
