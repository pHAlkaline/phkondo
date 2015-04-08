<?php

App::uses('AppController', 'Controller');

/**
 * Entities Controller
 *
 * @property Entity $Entity
 * @property PaginatorComponent $Paginator
 */
class FractionEntitiesController extends AppController {

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
    public $uses = array('Entity', 'Fraction');

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
        $options = array('conditions' => array('Entity.' . $this->Entity->primaryKey => $id));
        $this->set('entity', $this->Entity->find('first', $options));
        $this->set('fractionId', $this->Session->read('Condo.Fraction.ViewID'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($fractionId=null) {
        if ($fractionId != null && !$this->Fraction->exists($fractionId)) {
            $this->Session->setFlash(__('Invalid entity'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Entity->create();
            $this->request->data['Entity']['entity_type_id'] = 1; // Client Type
            if ($this->Entity->save($this->request->data)) {
                $this->Session->setFlash(__('The entity has been saved'), 'flash/success');
                if ($fractionId != null) {
                    $this->redirect(array('controller' => 'fractions', 'action' => 'edit', $fractionId));
                } else {
                    $this->redirect(array('controller' => 'fractions', 'action' => 'add'));
                }
            } else {
                $this->Session->setFlash(__('The entity could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $entityTypes = $this->Entity->EntityType->find('list', array('conditions' => array('id' => '1')));

        $this->set(compact('entityTypes', 'fractionId'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($fractionId=null) {
        if (!$this->Entity->exists($fractionId)) {
            $this->Session->setFlash(__('Invalid entity'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Entity->save($this->request->data)) {
                $this->Session->setFlash(__('The entity has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $fractionId));
            } else {
                $this->Session->setFlash(__('The entity could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $options = array('conditions' => array('Entity.' . $this->Entity->primaryKey => $fractionId));
            $this->request->data = $this->Entity->find('first', $options);
        }
        $entityTypes = $this->Entity->EntityType->find('list', array('conditions' => array('id' => '1')));
        $this->set(compact('entityTypes','fractionId'));
    }

    public function beforeRender() {

        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'view', $this->Session->read('Condo.Fraction.ViewID'))), 'text' => $this->Session->read('Condo.Fraction.ViewName'), 'active' => ''),
            array('link' => '', 'text' => ___n('Manager','Managers',2), 'active' => 'active')
        );
        $this->set(compact('breadcrumbs'));
    }

}
