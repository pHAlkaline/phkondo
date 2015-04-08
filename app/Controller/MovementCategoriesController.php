<?php

App::uses('AppController', 'Controller');

/**
 * MovementCategories Controller
 *
 * @property MovementCategory $MovementCategory
 * @property PaginatorComponent $Paginator
 */
class MovementCategoriesController extends AppController {

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
        $this->MovementCategory->recursive = 0;
         $this->Paginator->settings =Set::merge($this->Paginator->settings, 
                    array('conditions' => array
                    ("AND" => array("MovementCategory.active" => "1")
            )));
        $this->setFilter(array('MovementCategory.name'));
       
        $this->set('movementCategories', $this->paginate());
    }
    
    
    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->MovementCategory->exists($id)) {
            $this->Session->setFlash(__('Invalid movement category'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('MovementCategory.' . $this->MovementCategory->primaryKey => $id));
        $movementCategory=$this->MovementCategory->find('first', $options);
        $this->set('movementCategory', $movementCategory);
        $this->Session->write('MovementCategory.ViewID', $id);
        $this->Session->write('MovementCategory.ViewName', $movementCategory['MovementCategory']['name']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->MovementCategory->create();
            if ($this->MovementCategory->save($this->request->data)) {
                $this->Session->setFlash(__('The movement category has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view',$this->Movement->id));
            } else {
                $this->Session->setFlash(__('The movement category could not be saved. Please, try again.'), 'flash/error');
            }
        }
    }

    /**
     * addFromMovement method
     *
     * @return void
     */
    public function addFromMovement($movementId = null) {
        App::uses('Movement', 'model');
        $movement = new Movement();
        if ($movementId != null && !$movement->exists($movementId)) {
            $this->Session->setFlash(__('Invalid movement category'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->MovementCategory->create();
            if ($this->MovementCategory->save($this->request->data)) {
                $this->Session->setFlash(__('The movement category has been saved'), 'flash/success');
                if ($movementId != null) {
                    $this->redirect(array('controller' => 'movements', 'action' => 'edit', $movementId));
                } else {
                    $this->redirect(array('controller' => 'movements', 'action' => 'add'));
                }
            } else {
                $this->Session->setFlash(__('The movement category could not be saved. Please, try again.'), 'flash/error');
            }
        }

        if (!$this->Session->check('Condo.Account.ViewID')) {
            $this->Session->setFlash(__('Invalid account'), 'flash/error');
            $this->redirect(array('controller'=>'accounts','action' => 'index'));
        }

        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'accounts', 'action' => 'index')), 'text' => __n('Account','Accounts',2), 'active' => ''),
            
            array('link' => Router::url(array('controller' => 'accounts', 'action' => 'index', $this->Session->read('Condo.Account.ViewID'))), 'text' => $this->Session->read('Condo.Account.ViewName'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'movements', 'action' => 'index')), 'text' => __n('Movement','Movements',2), 'active' => ''),
            array('link' => '', 'text' => __('Add Movement Category'), 'active' => 'active')
        );
        $this->set(compact('breadcrumbs','movementId'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->MovementCategory->exists($id)) {
            $this->Session->setFlash(__('Invalid movement category'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->MovementCategory->save($this->request->data)) {
                $this->Session->setFlash(__('The movement category has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view',$id));
            } else {
                $this->Session->setFlash(__('The movement category could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array('MovementCategory.' . $this->MovementCategory->primaryKey => $id));
            $this->request->data = $this->MovementCategory->find('first', $options);
        }
        $this->Session->write('MovementCategory.ViewID', $id);
        $this->Session->write('MovementCategory.ViewName', $this->request->data['MovementCategory']['name']);
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
        $this->MovementCategory->id = $id;
        if (!$this->MovementCategory->exists()) {
            $this->Session->setFlash(__('Invalid movement category'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->MovementCategory->delete()) {
            $this->Session->setFlash(__('Movement category deleted'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Movement category can not be deleted'), 'flash/error');
        $this->redirect(array('action' => 'view',$id));
    }
    
    public function beforeRender() {
        if (isset($this->viewVars['breadcrumbs'])) {
            return;
        }
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => '', 'text' => __('Movement Categories'), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'movement_categories', 'action' => 'index')), 'text' => __('Movement Categories'), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->Session->read('MovementCategory.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'movement_categories', 'action' => 'index')), 'text' => __('Movement Categories'), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->Session->read('MovementCategory.ViewName'), 'active' => 'active');
                
                break;
        }
        $this->set(compact('breadcrumbs'));

    }

}
