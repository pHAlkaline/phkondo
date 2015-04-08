<?php

App::uses('AppController', 'Controller');

/**
 * FractionInsurances Controller
 *
 * @property Insurance $Insurance
 * @property PaginatorComponent $Paginator
 */
class FractionInsurancesController extends AppController {

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
    public $uses = array('Insurance');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Insurance->recursive = 0;
        $this->Paginator->settings = $this->paginate + array(
            'conditions' => array('Insurance.fraction_id' => $this->Session->read('Condo.Fraction.ViewID'))
        );
        $this->setFilter(array('Insurance.title', 'Insurance.insurance_company', 'Insurance.policy', 'InsuranceType.name'));

        $this->set('insurances', $this->paginate());
        $this->Session->delete('Condo.Insurance');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Insurance->exists($id)) {
            $this->Session->setFlash(__('Invalid insurance'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('Insurance.' . $this->Insurance->primaryKey => $id, 'Insurance.fraction_id' => $this->Session->read('Condo.Fraction.ViewID')));
        $insurance = $this->Insurance->find('first', $options);
        if (!count($insurance)) {
            $this->Session->setFlash(__('Invalid insurance'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->set('insurance', $insurance);
        $this->Session->write('Condo.Insurance.ViewID', $id);
        $viewName = $insurance['Insurance']['title'];
        if (isset($insurance['Fraction']['description'])) {
            $viewName = $viewName . ' ' . $insurance['Fraction']['description'];
        }
        $this->Session->write('Condo.Insurance.ViewName', $viewName);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Insurance->create();
            if ($this->Insurance->save($this->request->data)) {
                $this->Session->setFlash(__('The insurance has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Insurance->id));
            } else {
                $this->Session->setFlash(__('The insurance could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $condos = $this->Insurance->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $fractions = $this->Insurance->Fraction->find('list', array('conditions' => array('id' => $this->Session->read('Condo.Fraction.ViewID'))));
        $insuranceTypes = $this->Insurance->InsuranceType->find('list', array('conditions' => array('active' => '1')));
        $this->set(compact('condos', 'fractions', 'insuranceTypes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Insurance->exists($id)) {
            $this->Session->setFlash(__('Invalid insurance'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Insurance->save($this->request->data)) {
                $this->Session->setFlash(__('The insurance has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Session->setFlash(__('The insurance could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array('Insurance.' . $this->Insurance->primaryKey => $id));
            $this->request->data = $this->Insurance->find('first', $options);
        }
        $condos = $this->Insurance->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $fractions = $this->Insurance->Fraction->find('list', array('conditions' => array('id' => $this->Session->read('Condo.Fraction.ViewID'))));
        $insuranceTypes = $this->Insurance->InsuranceType->find('list', array('conditions' => array('active' => '1')));
        $this->set(compact('condos', 'fractions', 'insuranceTypes'));
        $viewName = $this->request->data['Insurance']['title'];
        if (isset($fractions[$this->request->data['Insurance']['fraction_id']])) {
            $viewName = $this->request->data['Insurance']['title'] . ' ' . $fractions[$this->request->data['Insurance']['fraction_id']];
        }
        $this->Session->write('Condo.Insurance.ViewName', $viewName);
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
        $this->Insurance->id = $id;
        if (!$this->Insurance->exists()) {
           $this->Session->setFlash(__('Invalid insurance'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Insurance->delete()) {
            $this->Session->setFlash(__('Insurance deleted'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Insurance can not be deleted'), 'flash/error');
        $this->redirect(array('action' => 'view', $id));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Condo.Fraction.ViewID')) {
            $this->Session->setFlash(__('Invalid fraction'), 'flash/error');
            $this->redirect(array('controller' => 'fractions', 'action' => 'index'));
        }
    }

    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index')), 'text' => __n('Fraction','Fractions',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'view', $this->Session->read('Condo.Fraction.ViewID'))), 'text' => $this->Session->read('Condo.Fraction.ViewName'), 'active' => ''),
            array('link' => Router::url(array('action' => 'index')), 'text' => __n('Insurance','Insurances',2), 'active' => ''),
        );

        switch ($this->action) {
            case 'view':
                $breadcrumbs[5] = array('link' => Router::url(array('action' => 'index')), 'text' => __n('Insurance','Insurances',2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->Session->read('Condo.Insurance.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[5] = array('link' => Router::url(array('action' => 'index')), 'text' => __n('Insurance','Insurances',2), 'active' => '');
                $breadcrumbs[6] = array('link' => '', 'text' => $this->Session->read('Condo.Insurance.ViewName'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }

}
