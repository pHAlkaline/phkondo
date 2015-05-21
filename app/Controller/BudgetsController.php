<?php

App::uses('AppController', 'Controller');

/**
 * Budgets Controller
 *
 * @property Budget $Budget
 * @property PaginatorComponent $Paginator
 */
class BudgetsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'RequestHandler');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Budget->contain(array('BudgetType','BudgetStatus'));
        $this->Paginator->settings = $this->paginate + array(
            'conditions' => array('Budget.condo_id' => $this->Session->read('Condo.ViewID'))
        );
        $this->setFilter(array('Budget.title', 'BudgetType.name'));
        $this->set('budgets', $this->paginate());
        $this->Session->delete('Condo.Budget');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Budget->contain(array('Note','BudgetStatus','FiscalYear','BudgetType','SharePeriodicity','ShareDistribution'));
        if (!$this->Budget->exists($id)) {
            $this->Session->setFlash(__('Invalid budget'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $options = array('conditions' => array('Budget.' . $this->Budget->primaryKey => $id));
        $budget = $this->Budget->find('first', $options);
        $this->set(compact('budget'));
        $this->Session->write('Condo.Budget.ViewID', $id);
        $this->Session->write('Condo.Budget.ViewName', $budget['Budget']['title']);
        $this->Session->write('Condo.Budget.Status', $budget['Budget']['budget_status_id']);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            if ($this->request->data['Budget']['share_periodicity_id'] == 1) {
                $this->request->data['Budget']['shares'] = 1;
            }
            $this->Budget->create();
            $this->request->data['Budget']['requested_amount'] = $this->request->data['Budget']['amount'];
            if ($this->Budget->save($this->request->data)) {
                $this->Session->setFlash(__('The budget has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Budget->id));
            } else {
                $this->Session->setFlash(__('The budget could not be saved. Please, try again.'), 'flash/error');
            }
        }
        $condos = $this->Budget->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $fiscalYears = $this->Budget->FiscalYear->find('list', array('conditions' => array('id' => $this->Session->read('Condo.FiscalYearID'))));
        $budgetTypes = $this->Budget->BudgetType->find('list');
        $budgetStatuses = $this->Budget->BudgetStatus->find('list', array('conditions' => array('id' => array('1', '2'))));
        $sharePeriodicities = $this->Budget->SharePeriodicity->find('list');
        $shareDistributions = $this->Budget->ShareDistribution->find('list');
        $this->set(compact('condos', 'fiscalYears', 'budgetTypes', 'budgetStatuses', 'sharePeriodicities', 'shareDistributions'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Budget->exists($id)) {
            $this->Session->setFlash(__('Invalid budget'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $this->Budget->contain(array('Note'));
        $options = array('conditions' => array('Budget.' . $this->Budget->primaryKey => $id));
        $budget = $this->Budget->find('first', $options);
        $this->set(compact('budget'));
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['Budget']['share_periodicity_id']) && $this->request->data['Budget']['share_periodicity_id'] == 1) {
                $this->request->data['Budget']['shares'] = 1;
                $this->request->data['Budget']['requested_amount'] = $this->request->data['Budget']['amount'];
            }

            if ($this->Budget->save($this->request->data)) {
                $this->_setNotesStatus();
                $this->Session->setFlash(__('The budget has been saved'), 'flash/success');
                $this->redirect(array('action' => 'view', $this->Budget->id));
            } else {
                $this->Session->setFlash(__('The budget could not be saved. Please, try again.'), 'flash/error');
            }
        } else {
            $this->request->data = $budget;
        }

        if ($this->request->data['Budget']['fiscal_year_id'] != $this->Session->read('Condo.FiscalYearID')) {
            $this->Session->setFlash(__('Invalid budget'), 'flash/error');
            $this->redirect(array('action' => 'index'));
            ;
        }
        $condos = $this->Budget->Condo->find('list', array('conditions' => array('id' => $this->Session->read('Condo.ViewID'))));
        $fiscalYears = $this->Budget->FiscalYear->find('list', array('conditions' => array('id' => $this->Session->read('Condo.FiscalYearID'))));
        $budgetTypes = $this->Budget->BudgetType->find('list');
        $budgetStatuses = $this->Budget->BudgetStatus->find('list');
        $sharePeriodicities = $this->Budget->SharePeriodicity->find('list');
        $shareDistributions = $this->Budget->ShareDistribution->find('list');
        $this->set(compact('condos', 'fiscalYears', 'budgetTypes', 'budgetStatuses', 'sharePeriodicities', 'shareDistributions'));
        $this->Session->write('Condo.Budget.ViewID', $id);
        $this->Session->write('Condo.Budget.ViewName', $this->request->data['Budget']['title']);
        $this->Session->write('Condo.Budget.Status', $this->request->data['Budget']['budget_status_id']);
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
        $this->Budget->id = $id;
        if (!$this->Budget->exists()) {
            $this->Session->setFlash(__('Invalid budget'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }

        if (!$this->Budget->deletable()) {
            $this->Session->setFlash(__('This Budget can not be deleted, check budget status or existing notes already paid.'), 'flash/error');
            $this->redirect(array('action' => 'view', $id));
        }

        if ($this->Budget->Note->DeleteAll(array('Note.budget_id' => $id), false) && $this->Budget->delete()) {
            $this->Session->setFlash(__('Budget deleted'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Budget can not be deleted'), 'flash/error');
        $this->redirect(array('action' => 'view', $id));
    }

    /**
     * share_map method
     *
     * @return void
     */
    public function shares_map($id=null) {
        if (!$this->Budget->exists($id)) {
            $this->Session->setFlash(__('Invalid budget'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }

        $event = new CakeEvent('Phkondo.Budget.sharesMap', $this, array(
            'id' => $id,
        ));
        $this->getEventManager()->dispatch($event);
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Condo.ViewID') || !$this->Session->read('Condo.FiscalYearID')) {
            $this->Session->setFlash(__('Invalid condo or fiscal year'), 'flash/error');
            $this->redirect(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID')));
        }
    }

    public function beforeRender() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'index')), 'text' => __n('Condo','Condos',2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->Session->read('Condo.ViewID'))), 'text' => $this->Session->read('Condo.ViewName'), 'active' => ''),
            array('link' => '', 'text' => __n('Budget','Budgets',2), 'active' => 'active')
        );
        switch ($this->action) {
            case 'view':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'budgets', 'action' => 'index')), 'text' => __n('Budget','Budgets',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->Session->read('Condo.Budget.ViewName'), 'active' => 'active');
                break;
            case 'edit':
                $breadcrumbs[3] = array('link' => Router::url(array('controller' => 'budgets', 'action' => 'index')), 'text' => __n('Budget','Budgets',2), 'active' => '');
                $breadcrumbs[4] = array('link' => '', 'text' => $this->Session->read('Condo.Budget.ViewName'), 'active' => 'active');
                break;
        }
        $this->set(compact('breadcrumbs'));
    }

    private function _setNotesStatus() {
        //$modified = date('Y-m-d H:i:s');
        if ($this->request->data['Budget']['budget_status_id'] == '3') {
            $this->Budget->Note->updateAll(
                    array('Note.note_status_id' => '4', 'Note.modified=NOW()'), array('Note.budget_id' => $this->Budget->id, 'Note.note_status_id' => '1')
            );
        }
        if ($this->request->data['Budget']['budget_status_id'] == '1') {
            $this->Budget->Note->updateAll(
                    array('Note.note_status_id' => '1', 'Note.modified=NOW()'), array('Note.budget_id' => $this->Budget->id, 'Note.note_status_id' => '4')
            );
        }
    }

}
