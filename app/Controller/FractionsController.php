<?php

App::uses('AppController', 'Controller');

/**
 * Fractions Controller
 *
 * @property Fraction $Fraction
 * @property PaginatorComponent $Paginator
 */
class FractionsController extends AppController {
    
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
        $this->Fraction->contain('Entity','Manager');
        $this->Paginator->settings = $this->paginate + array(
            'conditions' => array('Fraction.condo_id' => $this->Session->read('Condo.ViewID')),
        );
       
        $this->setFilter(array('Fraction.fraction','Fraction.floor_location','Fraction.description','Fraction.mil_rate','Manager.name'));
        
        $this->set('fractions', $this->paginate());
        $this->Session->delete('Condo.Fraction');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Fraction->exists($id)) {
            $this->Session->setFlash(__('Invalid fraction'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $this->Fraction->contain('Manager');
        $options = array('conditions' => array('Fraction.' . $this->Fraction->primaryKey => $id));
        $fraction = $this->Fraction->find('first', $options);
        $this->set(compact('fraction'));
        $this->Session->write('Condo.Fraction.ViewID', $id);
        $this->Session->write('Condo.Fraction.ViewName', $fraction['Fraction']['description']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Fraction->create();
            if ($this->Fraction->save($this->request->data)) {
                $this->Session->setFlash(__('The fraction has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Fraction->id));
            } else {
                $this->Session->setFlash(__('The fraction could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $condos = $this->Fraction->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $this->set(compact('condos', 'managers'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Fraction->exists($id)) {
            $this->Session->setFlash(__('Invalid fraction'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Fraction->save($this->request->data)) {
                $this->Session->setFlash(__('The fraction has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Session->setFlash(__('The fraction could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array('Fraction.' . $this->Fraction->primaryKey => $id));
            $this->request->data = $this->Fraction->find('first', $options);
        }
        $condos = $this->Fraction->Condo->find('list',array('conditions'=>array('Condo.id'=>$this->request->data['Fraction']['condo_id'])));

        $this->Session->write('Condo.Fraction.ViewID', $id);
        $this->Session->write('Condo.Fraction.ViewName', $this->request->data['Fraction']['description']);
        
        $this->Fraction->contain('Entity');
        $fraction = $this->Fraction->find('first', array('conditions' => array('Fraction.id' => $this->Session->read('Condo.Fraction.ViewID'))));
        $entitiesInFraction = Set::extract('/Entity/id', $fraction);

        $managers = $this->Fraction->Manager->find('list', array('order' => 'Manager.name', 'conditions' => array('Manager.entity_type_id' => '1', 'Manager.id' => $entitiesInFraction)));

        $this->set(compact('condos', 'managers'));
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
        $this->Fraction->id = $id;
        if (!$this->Fraction->exists()) {
            $this->Session->setFlash(__('Invalid fraction'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        
        if (!$this->Fraction->deletable()) {
            $this->Session->setFlash(__('This Fraction can not be deleted, check existing notes already paid.'), 'flash/error');
            $this->redirect(array('action' => 'view', $id));
        }

        ClassRegistry::init('Note')->DeleteAll(array('Note.fraction_id' => $id));
        ClassRegistry::init('Receipt')->DeleteAll(array('Receipt.fraction_id' => $id));
        ClassRegistry::init('Insurance')->DeleteAll(array('Insurance.fraction_id' => $id));
        
        if ($this->Fraction->delete()) {
            $this->Session->setFlash(__('Fraction deleted'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Fraction can not be deleted'), 'flash/error');
        $this->redirect(array('action' => 'view', $id));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Condo.ViewID')) {
            $this->Session->setFlash(__('Invalid condo'), 'flash/error');
            $this->redirect(array('controller'=>'condos','action' => 'view',$this->Session->read('Condo.ViewID')));
        }
    }

    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __n('Fraction','Fractions',2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index')), 'text' => __n('Fraction','Fractions',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->Session->read('Condo.Fraction.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index')), 'text' => __n('Fraction','Fractions',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->Session->read('Condo.Fraction.ViewName'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }

}
