<?php

/**
 *
 * pHKondo : pHKondo software for condominium property managers (http://phalkaline.eu)
 * Copyright (c) pHAlkaline . (http://phalkaline.eu)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @copyright     Copyright (c) pHAlkaline . (http://phalkaline.eu)
 * @link          http://phkondo.net pHKondo Project
 * @package       app.Controller
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Condo', 'Model');
App::uses('Receipt', 'Model');

/**
 * Income Controller
 *
 * @property PaginatorComponent $Paginator
 */
class IncomeController extends AppController {

    public $useModel = false;

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
        /* $Condo = new Condo();
          $options = array('conditions' => array('Condo.' . $Condo->primaryKey => $this->getPhkRequestVar('condo_id')));
          $condo = $Condo->find('first', $options);
          $this->set(compact('condo')); */
    }

    public function receipts() {

        $model = ClassRegistry::init('IncomeReceipt');
        $Receipt = ClassRegistry::init('Receipt');

        if ($this->request->is('post')) {
            $model->set($this->request->data);
            if ($model->validates()) {
                $conditions = array();
                if ($model->data['IncomeReceipt']['condo_id'] != '') {
                    $conditions['conditions']['Receipt.condo_id'] = $model->data['IncomeReceipt']['condo_id'];
                }
                if ($model->data['IncomeReceipt']['status_id'] != '') {
                    $conditions['conditions']['Receipt.receipt_status_id'] = $model->data['Receipt']['status_id'];
                }
                $open_date = date(Configure::read('databaseDateFormat'), strtotime($model->data['IncomeReceipt']['open_date']));
                $close_date = date(Configure::read('databaseDateFormat'), strtotime($model->data['IncomeReceipt']['close_date']));

                $conditions['conditions']['And'] = ['payment_date BETWEEN ? AND ?' => array($open_date, $close_date)];
                $Receipt->contain(array('PaymentUser', 'ReceiptStatus', 'ReceiptPaymentType', 'Client', 'Condo', 'CancelUser'));
                $this->set('receipts', $Receipt->find('all', $conditions));
                $this->set('hasData', true);
            } else {
               // $this->Flash->Error(_('Errors occurred.') . var_dump($model->validationErrors));
            }
            // display the form with errors.
        }
        $condos = $Receipt->Condo->find('list');
        $statuses = $Receipt->ReceiptStatus->find('list', array('conditions' => array('active' => '1')));
        $this->set(compact('condos', 'statuses'));
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'pages', 'action' => 'index')), 'text' => __('Home'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'income', 'action' => 'index')), 'text' => __('Income Control'), 'active' => 'active'));

        switch ($this->action) {
            case 'receipts':
                $breadcrumbs[1]['active'] = '';
                $breadcrumbs[2] = array('link' => '', 'text' => __n('Receipt', 'Receipts', 2), 'active' => 'active');
                break;
        }
        $headerTitle = __('Income Control');
        $this->set(compact('breadcrumbs', 'headerTitle'));
    }

    public function isAuthorized($user) {

        //debug($this->request->controller);
        if (isset($user['role'])) {

            switch ($user['role']) {
                case 'admin':
                    return true;
                    break;
                case 'store_admin':
                    return true;
                    break;
                default:
                    return false;
                    break;
            }
        }


        return parent::isAuthorized($user);
    }

}
