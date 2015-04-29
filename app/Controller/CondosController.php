<?php

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
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Condo->contain('FiscalYear', 'Insurance', 'Maintenance');
        $this->Paginator->settings = Set::merge($this->Paginator->settings, array('conditions' => array
                        ("AND" => array("Condo.active" => "1")
        )));
        $this->setFilter(array('Condo.title', 'Condo.address'));

        $this->set('condos', $this->paginate());
        $this->Session->delete('Condo');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Condo->contain(array(
                'FiscalYear', 
                'Insurance', 
                'Maintenance', 
                'Account', 
                'Administrator' => array(
                    'Entity'=>array(
                        'fields'=>array('Entity.name')))));
        if (!$this->Condo->exists($id)) {
            $this->Session->setFlash(__('Invalid condo'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('Condo.' . $this->Condo->primaryKey => $id));
        $condo = $this->Condo->find('first', $options);
        $hasSharesDebt = $this->Condo->hasSharesDebt($id);


        $InvoiceConference = $this->InvoiceConference;
        $InvoiceConference->recursive = 0;
        $InvoiceConference->virtualFields = array('total_amount' => 'SUM(amount)');
        $hasDebt = 0;
        $this->Session->write('Condo.FiscalYearID', null);
        if (isset($condo['FiscalYear']) && count($condo['FiscalYear'])) {
            $hasDebt = $InvoiceConference->field('total_amount', array(
                'InvoiceConference.condo_id' => $this->Session->read('Condo.ViewID'),
                'InvoiceConference.document_date <=' => $condo['FiscalYear'][0]['close_date'],
                'InvoiceConference.payment_due_date <' => date('Y-m-d'),
                'OR' => array('InvoiceConference.payment_date' => null, 'InvoiceConference.payment_date >' => $condo['FiscalYear'][0]['close_date']),
            ));
            $this->Session->write('Condo.FiscalYearID', $condo['FiscalYear'][0]['id']);
        }
        $this->set(compact('condo', 'hasSharesDebt', 'hasDebt'));

        $this->Session->write('Condo.ViewID', $id);
        $this->Session->write('Condo.ViewName', $condo['Condo']['title']);
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
                $this->Session->setFlash(__('The condo has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Condo->id));
            } else {
                $this->Session->setFlash(__('The condo could not be saved. Please, try again.'), 'flash/error');
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
        $this->Condo->recursive = -1;
        if (!$this->Condo->exists($id)) {
            $this->Session->setFlash(__('Invalid condo'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Condo->save($this->request->data)) {
                $this->Session->setFlash(__('The condo has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Condo->id));
            } else {
                $this->Session->setFlash(__('The condo could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array('Condo.' . $this->Condo->primaryKey => $id));
            $this->request->data = $this->Condo->find('first', $options);
        }
        $this->Session->write('Condo.ViewID', $id);
        $this->Session->write('Condo.ViewName', $this->request->data['Condo']['title']);
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
        $this->Condo->id = $id;
        if (!$this->Condo->exists()) {
            $this->Session->setFlash(__('Invalid condo'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Condo->delete()) {
            $this->Session->setFlash(__('Condo deleted'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Condo can not be deleted, please check the existence of already paid notes'), 'flash/error');
        $this->redirect(array('action' => 'view', $id));
    }
    
    /**
     * draft method
     *
     * @return void
     */
    public function drafts() {
        
    }

    public function beforeRender() {

        if (!$this->Session->check('Condo.ViewID')) {
            $breadcrumbs = array(
                array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
                array('link' => '', 'text' => __n('Condo','Condos',2), 'active' => 'active')
            );
        } else {
            $breadcrumbs = array(
                array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
                array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
                array('link' => '', 'text' => $this->Session->read('Condo.ViewName'), 'active' => 'active')
            );
        }

        $this->set(compact('breadcrumbs'));
    }

}
