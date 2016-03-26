<?php

App::uses('AppController', 'Controller');

/**
 * SupportCategories Controller
 *
 * @property SupportCategory $SupportCategory
 * @property PaginatorComponent $Paginator
 */
class SupportCategoriesController extends AppController {

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
        $this->Paginator->settings = array_replace_recursive($this->Paginator->settings ,
                array('conditions' => array
                        ("AND" => array("SupportCategory.active" => "1")
        )));
        $this->setFilter(array('SupportCategory.name'));

        $this->set('supportCategories', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->SupportCategory->exists($id)) {
            $this->Flash->error(__('Invalid support category'));
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('SupportCategory.' . $this->SupportCategory->primaryKey => $id));
        $supportCategory = $this->SupportCategory->find('first', $options);
        $this->set('supportCategory', $supportCategory);

        $this->setPhkRequestVar('support_category_id', $id);
        $this->setPhkRequestVar('support_category_text', $supportCategory['SupportCategory']['name']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->SupportCategory->create();
            if ($this->SupportCategory->save($this->request->data)) {
                $this->Flash->success(__('The support category has been saved'));
                $this->redirect(array('action' => 'view', $this->SupportCategory->id));
            } else {
                $this->Flash->error(__('The support category could not be saved. Please, try again.'));
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
        if (!$this->SupportCategory->exists($id)) {
            $this->Flash->error(__('Invalid support category'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->SupportCategory->save($this->request->data)) {
                $this->Flash->success(__('The support category has been saved'));
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Flash->error(__('The support category could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SupportCategory.' . $this->SupportCategory->primaryKey => $id));
            $this->request->data = $this->SupportCategory->find('first', $options);
        }
        $this->setPhkRequestVar('support_category_id', $id);
        $this->setPhkRequestVar('support_category_text', $this->request->data['SupportCategory']['name']);
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
        $this->SupportCategory->id = $id;
        if (!$this->SupportCategory->exists()) {
            $this->Flash->error(__('Invalid support category'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->SupportCategory->delete()) {
            $this->Flash->success(__('Support category deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Support category can not be deleted'));
        $this->redirect(array('action' => 'view', $id));
    }

    public function beforeRender() {
        parent::beforeRender();
        if (isset($this->viewVars['breadcrumbs'])) {
            return;
        }
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => '', 'text' => __('Support Categories'), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'support_categories', 'action' => 'index')), 'text' => __('Support Categories'), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('support_category_text'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[1] = array('link' => Router::url(array('controller' => 'support_categories', 'action' => 'index')), 'text' => __('Support Categories'), 'active' => '');
                $breadcrumbs[2] = array('link' => '', 'text' => $this->getPhkRequestVar('support_category_text'), 'active' => 'active');

                break;
        }
        $headerTitle=__('Support Categories');
        $this->set(compact('breadcrumbs','headerTitle'));
    }

}
