<?php

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
        
        $this->Administrator->recursive = 0;
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
            $this->Session->setFlash(__('Invalid administrator'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
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
                $this->Session->setFlash(__('The administrator has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view',$this->Administrator->id));
            } else {
                $this->Session->setFlash(__('The administrator could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $condos = $this->Administrator->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $this->Fraction = $this->Administrator->Condo->Fraction;
        $options = array('conditions' => array(
                'Administrator.condo_id' => $this->Session->read('Condo.ViewID'),
                'Administrator.fiscal_year_id' => $this->Session->read('Condo.FiscalYearID')));
        $administrators=$this->Administrator->find('all', $options);
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
            $this->Session->setFlash(__('Invalid administrator'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Administrator->save($this->request->data)) {
                $this->Session->setFlash(__('The administrator has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view',$this->Administrator->id));
            } else {
                $this->Session->setFlash(__('The administrator could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array('Administrator.' . $this->Administrator->primaryKey => $id));
            $this->request->data = $this->Administrator->find('first', $options);
        }
        $condos = $this->Administrator->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $this->Fraction = $this->Administrator->Condo->Fraction;
        $options = array('conditions' => array(
                'Administrator.id <>' => $id,
                'Administrator.condo_id' => $this->Session->read('Condo.ViewID'),
                'Administrator.fiscal_year_id' => $this->Session->read('Condo.FiscalYearID')));
        $administrators=$this->Administrator->find('all', $options);
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
            $this->Session->setFlash(__('Invalid administrator'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Administrator->delete()) {
            $this->Session->setFlash(__('Administrator deleted'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Administrator can not be deleted'), 'flash/error');
        $this->redirect(array('action' => 'view',$id));
    }
    
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Administrator->recursive=1;
        if (!$this->Session->check('Condo.ViewID') || !$this->Session->read('Condo.FiscalYearID')) {
            $this->Session->setFlash(__('Invalid condo or fiscal year'), 'flash/error');
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
