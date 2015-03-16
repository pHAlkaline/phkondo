<?php

App::uses('AppController', 'Controller');

/**
 * Entities Controller
 *
 * @property Entity $Entity
 * @property PaginatorComponent $Paginator
 */
class EntitiesController extends AppController {
    
    public $uses = array ('Entity','Maintenance');

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
        $this->Paginator->settings = $this->paginate;
        $this->setFilter(array('Entity.name','EntityType.name','Entity.address','Entity.email','Entity.contacts','Entity.vat_number'));
        $this->set('entities', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Entity->exists($id)) {
            $this->Session->setFlash(__('Invalid entity'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $this->Entity->recursive=2;
        $this->Entity->bindModel(
        array(
            'hasAndBelongsToMany' => array(
                'Fraction' => array(
                    'className'              => 'Fraction',
                    'joinTable'              => 'entities_fractions',
                    'foreignKey'             => 'entity_id',
                    'associationForeignKey'  => 'fraction_id',
                    'unique'                 => true,
                    )
                )
            )
        );
        
        $options = array('conditions' => array('Entity.' . $this->Entity->primaryKey => $id));
        $entity=$this->Entity->find('first', $options);
        $this->set('entity',$entity );
        $this->Session->write('Entity.ViewID', $id);
        $this->Session->write('Entity.ViewName', $entity['Entity']['name']);
        
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Entity->create();
            if ($this->Entity->save($this->request->data)) {
                $this->Session->setFlash(__('The entity has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view',$this->Entity->id));
            } else {
                $this->Session->setFlash(__('The entity could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $entityTypes = $this->Entity->EntityType->find('list');
        $this->set(compact('entityTypes'));
    }

    

    /**
     * addFromMaintenance method
     *
     * @return void
     */
    public function addFromMaintenance($maintenanceId = null) {
        
        $maintenance = $this->Maintenance;
        if ($maintenanceId != null && !$maintenance->exists($maintenanceId)) {
            $this->Session->setFlash(__('Invalid entity'), 'flash/error');
            $this->redirect(array('controller'=>'maintenance','action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Entity->create();
            $this->request->data['Entity']['entity_type_id'] = 2; // Client Type
            if ($this->Entity->save($this->request->data)) {
                $this->Session->setFlash(__('The entity has been saved'), 'flash/success');
                if ($maintenanceId != null) {
                    $this->redirect(array('controller' => 'maintenances', 'action' => 'edit', $maintenanceId));
                } else {
                    $this->redirect(array('controller' => 'maintenances', 'action' => 'add'));
                }
            } else {
                $this->Session->setFlash(__('The entity could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $entityTypes = $this->Entity->EntityType->find('list', array('conditions' => array('id' => '2')));

        $this->set(compact('entityTypes', 'maintenanceId'));

        if (!$this->Session->check('Condo.ViewID')) {
            $this->Session->setFlash(__('Invalid condo'), 'flash/error');
            $this->redirect(array('controller'=>'maintenances','action' => 'index'));
        }

        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __('Condos'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'maintenances', 'action' => 'index')), 'text' => __('Maintenances'), 'active' => ''),
            array('link' => '', 'text' => __('Suppliers'), 'active' => 'active')
        );
        $this->set(compact('breadcrumbs'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Entity->exists($id)) {
            $this->Session->setFlash(__('Invalid entity'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Entity->save($this->request->data)) {
                $this->Session->setFlash(__('The entity has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view',$this->Entity->id));
            } else {
                $this->Session->setFlash(__('The entity could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array('Entity.' . $this->Entity->primaryKey => $id));
            $this->request->data = $this->Entity->find('first', $options);
        }
        $entityTypes = $this->Entity->EntityType->find('list');
        $this->set(compact('entityTypes'));
        $this->Session->write('Entity.ViewID', $id);
        $this->Session->write('Entity.ViewName', $this->request->data['Entity']['name']);
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
        $this->Entity->id = $id;
        if (!$this->Entity->exists()) {
            $this->Session->setFlash(__('Invalid entity'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Entity->delete()) {
            $this->Session->setFlash(__('Entity deleted'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Entity can not be deleted'), 'flash/error');
        $this->redirect(array('action' => 'view',$id));
    }

    public function beforeRender() {
        if (isset($this->viewVars['breadcrumbs'])) {
            return;
        }
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => '', 'text' => __('Entities'), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'entities', 'action' => 'index')), 'text' => __('Entities'), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->Session->read('Entity.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'entities', 'action' => 'index')), 'text' => __('Entities'), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->Session->read('Entity.ViewName'), 'active' => 'active');
                
                break;
        }
        $this->set(compact('breadcrumbs'));
//$this->Auth->allow('add'); // Letting users register themselves
    }

}
