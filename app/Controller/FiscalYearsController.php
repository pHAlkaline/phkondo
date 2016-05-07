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
 * Fiscal Years Controller
 *
 * @property FiscalYear $FiscalYear
 * @property PaginatorComponent $Paginator
 */
class FiscalYearsController extends AppController {

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
            'conditions' => array('FiscalYear.condo_id' => $this->getPhkRequestVar('condo_id'))
        ));
        $this->setFilter(array('FiscalYear.title'));
        $this->set('fiscalYears', $this->Paginator->paginate('FiscalYear'));
        
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->FiscalYear->exists($id)) {
            $this->Flash->error(__('Invalid fiscal year'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $options = array('conditions' => array('FiscalYear.' . $this->FiscalYear->primaryKey => $id));
        $fiscalYear = $this->FiscalYear->find('first', $options);
        $this->set('fiscalYear', $fiscalYear);
        $this->setPhkRequestVar('fiscal_year_id',$id);
       
        
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->FiscalYear->create();
            if ($this->FiscalYear->save($this->request->data)) {
                if ($this->request->data['FiscalYear']['active'] == '1') {
                    $this->_setAccountBalanceByFiscalYear($this->FiscalYear->id);
                }
                $this->Flash->success(__('The fiscal year has been saved'));
                $this->redirect(array('action' => 'view', $this->FiscalYear->id,'?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The fiscal year could not be saved. Please, try again.'));
            }
        }
        $condos = $this->FiscalYear->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $this->set(compact('condos'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->FiscalYear->exists($id)) {
            $this->Flash->error(__('Invalid fiscal year'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->FiscalYear->save($this->request->data)) {
                if ($this->request->data['FiscalYear']['active'] == '1') {
                    $this->_setAccountBalanceByFiscalYear($this->request->data['FiscalYear']['id']);
                }
                $this->Flash->success(__('The fiscal year has been saved'));
                $this->redirect(array('action' => 'view', $this->FiscalYear->id,'?'=>$this->request->query));
            } else {
                $this->Flash->error(__('The fiscal year could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('FiscalYear.' . $this->FiscalYear->primaryKey => $id));
            $this->request->data = $this->FiscalYear->find('first', $options);
        }
        $condos = $this->FiscalYear->Condo->find('list', array('conditions' => array('id' => $this->getPhkRequestVar('condo_id'))));
        $this->set(compact('condos'));
        $this->setPhkRequestVar('fiscal_year_id',$id);
       
    }

    /**
     * active method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function active($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->FiscalYear->id = $id;
        if (!$this->FiscalYear->exists()) {
            $this->Flash->error(__('Invalid fiscal year'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        if ($this->FiscalYear->active()) {
            $this->_setAccountBalanceByFiscalYear($id);
            $this->setPhkRequestVar('fiscal_year_id',$id);
            $this->Flash->success(__('Fiscal Year active'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Flash->error(__('Fiscal Year is not active'));
        $this->redirect(array('action' => 'index','?'=>$this->request->query));
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

        $this->FiscalYear->id = $id;
        if (!$this->FiscalYear->exists()) {
            $this->Flash->error(__('Invalid fiscal year'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }

        if (!$this->FiscalYear->deletable()) {
            $this->Flash->error(__('This Fiscal Year can not be deleted, check existing notes already paid.'));
            $this->redirect(array('action' => 'view', $id,'?'=>$this->request->query));
        }

        if ($this->FiscalYear->delete()) {
            $this->Flash->success(__('Fiscal Year deleted'));
            $this->redirect(array('action' => 'index','?'=>$this->request->query));
        }
        $this->Flash->error(__('Fiscal Year can not be deleted'));
        $this->redirect(array('action' => 'view', $id,'?'=>$this->request->query));
    }

    private function _setAccountBalanceByFiscalYear($id = null) {
        $this->FiscalYear->id = $id;
        $condo_id = $this->FiscalYear->field('condo_id');
        //$this->FiscalYear->Condo->recursive=1;
        $this->FiscalYear->Condo->contain('Account');
        $accounts = $this->FiscalYear->Condo->find('first', array('conditions' => array('Condo.id' => $condo_id)));
        foreach ($accounts['Account'] as $account) {
            $this->FiscalYear->Condo->Account->setAccountBalanceByFiscalYear($account['id'], $id);
        }
        
       
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('condo_id')) {
            $this->Flash->error(__('Invalid condo or fiscal year'));
            $this->redirect(array('controller' => 'condos', 'action' => 'index'));
        }
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo', 'Condos', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view',$this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text'), 'active' => ''),
            array('link' => '', 'text' => __n('Fiscal Year', 'Fiscal Years', 2), 'active' => 'active')
        );

        switch ($this->action) {
            case 'view':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'fiscal_years', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Fiscal Year', 'Fiscal Years', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('fiscal_year_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'fiscal_years', 'action' => 'index','?'=>$this->request->query)), 'text' => __n('Fiscal Year', 'Fiscal Years', 2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->getPhkRequestVar('fiscal_year_text'), 'active' => 'active');
                break;
        }
        $headerTitle=__n('Fiscal Year', 'Fiscal Years', 2);
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
