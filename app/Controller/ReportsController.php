<?php

App::uses('AppController', 'Controller');


/**
 * Reports Controller
 *
 * @property PaginatorComponent $Paginator
 */
class ReportsController extends AppController {

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
       $this->render('notfound'); 
    }
    
   

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Condo.ViewID')) {
            $this->Session->setFlash(__('Invalid condo'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __('Condos'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __('Reports'), 'active' => 'active')
        );
      

        $this->set(compact('breadcrumbs'));
    }

}
