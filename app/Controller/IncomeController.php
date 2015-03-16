<?php

App::uses('AppController', 'Controller');
App::uses('Condo', 'Model');
App::uses('Receipt', 'Model');


/**
 * Income Controller
 *
 * @property PaginatorComponent $Paginator
 */
class IncomeController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('RequestHandler');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $Condo = new Condo();
        $options = array('conditions' => array('Condo.' . $Condo->primaryKey => $this->Session->read('Condo.ViewID')));
        $condo = $Condo->find('first', $options);
        $this->set(compact('condo'));
    }

    public function receipts() {
        $Receipt = new Receipt();
        $Receipt->recursive=0;
        $condos = $Receipt->Condo->find('list');
        $receiptStatuses = $Receipt->ReceiptStatus->find('list', array('conditions' => array('active' => '1')));
        $this->set(compact('condos', 'clients', 'receiptStatuses'));
        if (isset($this->request->data['Receipt'])){
           
            $conditions=array('conditions');
            if ($this->request->data['Receipt']['condo_id']!=''){
                $conditions['conditions']['Receipt.condo_id']=$this->request->data['Receipt']['condo_id'];
            }
            if ($this->request->data['Receipt']['receipt_status_id']!=''){
                $conditions['conditions']['Receipt.receipt_status_id']=$this->request->data['Receipt']['receipt_status_id'];
            }
            if ($this->request->data['Receipt']['payment_date']!=''){
                $conditions['conditions']['Receipt.payment_date']=$this->request->data['Receipt']['payment_date']['year'].'-'.$this->request->data['Receipt']['payment_date']['month'].'-'.$this->request->data['Receipt']['payment_date']['day'];
            }
           $this->set('receipts', $Receipt->find('all', $conditions));
           $this->set('hasData', true);
        }
        
        
    }

    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'income', 'action' => 'index')), 'text' => __('Income Control'), 'active' => 'active'));
        
        switch ($this->action) {
            case 'receipts':
                $breadcrumbs[1]['active']='';
                $breadcrumbs[2] = array('link' => '', 'text' => __('Receipts'), 'active' => 'active');
                break;
            
        }
        $this->set(compact('breadcrumbs'));
        
    }
    
    public function isAuthorized($user) {
        
        //debug($this->request->controller);
        if (isset($user['role'])){
            
            switch ($user['role']){
                case 'admin':
                    return true;
                    break;
                case 'store_admin':
                    return true;
                    break;
                default:
                    return false;
                    break;
                
            }
        }
        
        
        return parent::isAuthorized($user);
    }


}
