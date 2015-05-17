<?php

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
        $this->FiscalYear->recursive = 0;
        $this->Paginator->settings = $this->paginate + array(
            'conditions' => array('FiscalYear.condo_id' => $this->Session->read('Condo.ViewID'))
        );
        $this->setFilter(array('FiscalYear.title'));
        $this->set('fiscalYears', $this->paginate());
        $this->Session->delete('Condo.FiscalYear');
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
            $this->Session->setFlash(__('Invalid fiscal year'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('FiscalYear.' . $this->FiscalYear->primaryKey => $id));
        $fiscalYear= $this->FiscalYear->find('first', $options);
        $this->set('fiscalYear', $fiscalYear);
        $this->Session->write('Condo.FiscalYear.ViewID', $id);
        $this->Session->write('Condo.FiscalYear.ViewName', $fiscalYear['FiscalYear']['title']);
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
                if ($this->request->data['FiscalYear']['active']=='1'){
                    $this->_setAccountBalanceByFiscalYear($this->FiscalYear->id);
                }
                $this->Session->setFlash(__('The fiscal year has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view',$this->FiscalYear->id));
            } else {
                $this->Session->setFlash(__('The fiscal year could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $condos = $this->FiscalYear->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
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
            $this->Session->setFlash(__('Invalid fiscal year'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->FiscalYear->save($this->request->data)) {
                if ($this->request->data['FiscalYear']['active']=='1'){
                    $this->_setAccountBalanceByFiscalYear($this->request->data['FiscalYear']['id']);
                }
                $this->Session->setFlash(__('The fiscal year has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view',$this->FiscalYear->id));
            } else {
                $this->Session->setFlash(__('The fiscal year could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array('FiscalYear.' . $this->FiscalYear->primaryKey => $id));
            $this->request->data = $this->FiscalYear->find('first', $options);
        }
        $condos = $this->FiscalYear->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $this->set(compact('condos'));
        $this->Session->write('Condo.FiscalYear.ViewID', $id);
        $this->Session->write('Condo.FiscalYear.ViewName', $this->request->data['FiscalYear']['title']);
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
            $this->Session->setFlash(__('Invalid fiscal year'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->FiscalYear->active()) {
            $this->_setAccountBalanceByFiscalYear($id);
            $this->Session->setFlash(__('Fiscal Year active'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Fiscal Year is not active'), 'flash/error');
        $this->redirect(array('action' => 'index'));
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
            $this->Session->setFlash(__('Invalid fiscal year'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        
        if (!$this->FiscalYear->deletable()) {
            $this->Session->setFlash(__('This Fiscal Year can not be deleted, check existing notes already paid.'), 'flash/error');
            $this->redirect(array('action' => 'view', $id));
        }

        if ($this->FiscalYear->delete()) {
            $this->Session->setFlash(__('Fiscal Year deleted'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Fiscal Year can not be deleted'), 'flash/error');
        $this->redirect(array('action' => 'view',$id));
    }
    
    private function _setAccountBalanceByFiscalYear($id=null){
        $this->FiscalYear->id=$id;
        $condo_id = $this->FiscalYear->field('condo_id');
        $this->FiscalYear->Condo->recursive=1;
        $this->FiscalYear->Condo->contain('Account');
        $accounts=$this->FiscalYear->Condo->find('first',array('conditions'=>array('Condo.id'=>$condo_id)));
        foreach ($accounts['Account'] as $account){
            $this->FiscalYear->Condo->Account->setAccountBalanceByFiscalYear($account['id'],$id);
        }
        //exit();
        
       
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->FiscalYear->recursive = -1;
        if (!$this->Session->check('Condo.ViewID')) {
            $this->Session->setFlash(__('Invalid condo or fiscal year'), 'flash/error');
            $this->redirect(array('controller'=>'condos','action' => 'view',$this->Session->read('Condo.ViewID')));
        }
    }
    
    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __n('Fiscal Year','Fiscal Years',2), 'active' => 'active')
        );
        
        switch ($this->action) {
            case 'view':
                 $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'fiscal_years', 'action' => 'index')), 'text' => __n('Fiscal Year','Fiscal Years',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->Session->read('Condo.FiscalYear.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                  $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'fiscal_years', 'action' => 'index')), 'text' => __n('Fiscal Year','Fiscal Years',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->Session->read('Condo.FiscalYear.ViewName'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }

}
