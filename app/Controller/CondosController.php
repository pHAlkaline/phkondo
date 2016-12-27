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
 * @since         pHKondo v 1.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */

App::uses('AppController', 'Controller');
App::uses('InvoiceConference', 'Model');

/**
 * Condos Controller
 *
 * @property Condo $Condo
 * @property PaginatorComponent $Paginator
 */
class CondosController extends AppController {

    public $uses = array('Condo','InvoiceConference');
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
        
       
        $this->Paginator->settings = array_merge($this->Paginator->settings , array(
            'contain' => array('FiscalYear', 'Insurance', 'Maintenance'),
            'limit'=>50,
            'conditions' => array(
                "AND" => array("Condo.active" => "1"))
        ));
        $this->setFilter(array('Condo.title', 'Condo.address'));
        $this->set('condos', $this->Paginator->paginate('Condo'));
        
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Condo->exists($id)) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('action' => 'index'));
        }
        $this->setPhkRequestVar('condo_id',$id);
        $this->Condo->contain(array(
                'Comment',
                'FiscalYear', 
                'Insurance', 
                'Maintenance', 
                'Account', 
                'Administrator' => array(
                    'conditions'=>array('Administrator.fiscal_year_id' => $this->getPhkRequestVar('fiscal_year_id')),
                    'Entity'=>array(
                        'fields'=>array('Entity.name')))));
        $options = array('conditions' => array('Condo.' . $this->Condo->primaryKey => $id));
        $condo = $this->Condo->find('first', $options);
        $hasSharesDebt = $this->Condo->hasSharesDebt($id);


        $InvoiceConference = $this->InvoiceConference;
        $InvoiceConference->virtualFields = array('total_amount' => 'SUM(amount)');
        $hasDebt = 0;
        if (isset($condo['FiscalYear']) && count($condo['FiscalYear'])) {
            $hasDebt = $InvoiceConference->field('total_amount', array(
                'InvoiceConference.condo_id' => $this->getPhkRequestVar('condo_id'),
                'InvoiceConference.document_date <=' => $condo['FiscalYear'][0]['close_date'],
                'InvoiceConference.payment_due_date <' => date(Configure::read('databaseDateFormat')),
                'OR' => array('InvoiceConference.payment_date' => null, 'InvoiceConference.payment_date >' => $condo['FiscalYear'][0]['close_date']),
            ));
            
        }
        $this->set(compact('condo', 'hasSharesDebt', 'hasDebt'));

    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Condo->create();
            if ($this->Condo->save($this->request->data)) {
                //debug($this->request->data);
                $this->Condo->ReceiptCounter->create();
                $this->Condo->ReceiptCounter->save(array('ReceiptCounter' => array('condo_id' => $this->Condo->id, 'counter' => 0)));
                $this->Flash->success(__('The condo has been saved'));
                $this->redirect(array('action' => 'view', $this->Condo->id));
            } else {
                $this->Flash->error(__('The condo could not be saved. Please, try again.'));
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
        if (!$this->Condo->exists($id)) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Condo->save($this->request->data)) {
                $this->Flash->success(__('The condo has been saved'));
                $this->redirect(array('action' => 'view', $this->Condo->id));
            } else {
                $this->Flash->error(__('The condo could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Condo.' . $this->Condo->primaryKey => $id));
            $this->request->data = $this->Condo->find('first', $options);
        }
        
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
        if (!in_array(AuthComponent::user('role'), array('admin','store_admin'))){
            throw new MethodNotAllowedException();
        }
                
        $this->Condo->id = $id;
        if (!$this->Condo->exists()) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Condo->delete()) {
            $this->Flash->success(__('Condo deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Condo can not be deleted, please check the existence of already paid notes'));
        $this->redirect(array('action' => 'view', $id));
    }
    
    /**
     * drafts method
     *
     * @return void
     */
    public function drafts() {
    }
    
    /**
     * attachments method
     *
     * @return void
     */
    public function attachments() {
        
    }

    public function beforeRender() {
        parent::beforeRender();
        if (!isset($this->phkRequestData['condo_id'])) {
            $breadcrumbs = array(
                array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
                array('link' => '', 'text' => __n('Condo','Condos',2), 'active' => 'active')
            );
            $headerTitle=__('Condos');
        } else {
            $breadcrumbs = array(
                array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
                array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
                array('link' => '', 'text' => $this->getPhkRequestVar('condo_text'), 'active' => 'active')
            );
            $headerTitle=__('Condos');
        }

        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
