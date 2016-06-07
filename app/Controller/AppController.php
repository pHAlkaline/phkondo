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
App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $theme = null;
    public $components = array(
        'DebugKit.Toolbar' => array('panels' => array('ClearCache.ClearCache')),
        'Paginator',
        'Session',
        'Flash',
        'Auth',
        'Cookie',
        'MaintenanceMode');
    public $phkRequestData = array();

    public function beforeFilter() {

        $this->Paginator->settings['paramType'] = 'querystring';
        if ($this->Session->read('User.language')) {
            Configure::write('Config.language', $this->Session->read('User.language'));
        }

        $this->theme = $this->getTheme();
        $this->Auth->authenticate = array(AuthComponent::ALL => array('userModel' => 'User', 'scope' => array("User.active" => 1)), 'Form');
        $this->Auth->loginRedirect = Router::url(array('plugin' => null, 'controller' => 'condos', 'action' => 'index'), true);
        $this->Auth->logoutRedirect = Router::url(array('plugin' => null, 'controller' => 'users', 'action' => 'login'), true);
        $this->Auth->authorize = array('Controller');
        $this->Auth->flash = array('element' => 'error', 'key' => null, 'params' => array());
        $this->Auth->allow('display', 'login', 'logout');
        if (Configure::read('Access.open') === true) {
            $this->Auth->allow();
        }
        $this->rememberMe();
        $this->setPhkRequestVars($this->request->query);
    }

    public function beforeRender() {
        $phkRequestData = $this->phkRequestData;
        $this->set(compact('phkRequestData'));
    }

    private function rememberMe() {
// set cookie options
        $this->Cookie->httpOnly = true;

        if (!$this->Auth->loggedIn() && $this->Cookie->read('rememberMe')) {
            $cookie = $this->Cookie->read('rememberMe');
            $user = false;
            if (isset($cookie['username']) && isset($cookie['password'])) {
                $this->loadModel('User'); // If the User model is not loaded already
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.username' => $cookie['username'],
                        'User.password' => $cookie['password']
                    )
                ));
            }

            if ($user && !$this->Auth->login($user['User'])) {
                Router::url(array('plugin' => null, 'controller' => 'condos', 'action' => 'index'), true); // destroy session & cookie
            }
        }
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
                case 'colaborator':
                    return true;
                    break;
            }
        }

// Default deny
        return false;
    }

    public function setFilter($fields) {

        $this->set('keyword', '');
        /* if (isset($this->request->params['named']['keyword'])) {
          $keyword = $this->request->params['named']['keyword'];
          }
          if (isset($this->request->data['keyword'])) {
          $keyword = $this->request->data['keyword'];
          } */
        if (isset($this->request->query['keyword'])) {
            $keyword = $this->request->query['keyword'];
        }


        if (isset($keyword) && ($keyword == '' || $keyword == __('Search'))) {
            unset($keyword);
        }
        if (isset($keyword)) {
            $arrayConditions = array();
            foreach ($fields as $field) {
                $arrayConditions[$field . ' LIKE'] = "%" . $keyword . "%";
            }
            $this->Paginator->settings['conditions'] = Set::merge($this->Paginator->settings['conditions'], array
                        ("OR" => $arrayConditions
            ));

            $this->set('keyword', $keyword);
        }
    }

    public function getPhkRequestVar($key = '') {
        if (isset($this->phkRequestData[$key])) {
            return $this->phkRequestData[$key];
        }
        throw new BadRequestException('Missig request var ' . $key);
        return null;
    }

    public function setPhkRequestVars($values = null) {
        foreach ($values as $key => $value) {
            $this->setPhkRequestVar($key, $value);
        }
    }

    public function setPhkRequestVar($key, $value) {
        $this->phkRequestData[$key] = $value;
        $this->setInvoiceData();
        $this->setInsuranceData();
        $this->setMaintenanceData();
        $this->setNoteData();
        $this->setReceiptData();
        $this->setOwnerData();
        $this->setSupplierData();
        $this->setFractionData();
        $this->setAccountData();
        $this->setBudgetData();
        $this->setAdministratorData();
        $this->setCondoData();
        $this->setFiscalYearData();
    }

    private function setCondoData() {
        if (isset($this->phkRequestData['condo_id']) && !isset($this->phkRequestData['condo_text'])) {
            App::import("Model", "Condo");
            $condo = new Condo();
            $result = $condo->find("first", array('conditions' => array('Condo.id' => $this->phkRequestData['condo_id'])));
            $this->phkRequestData['condo_id'] = $result['Condo']['id'];
            $this->phkRequestData['condo_text'] = $result['Condo']['title'];
        }
    }

    private function setFiscalYearData() {

        if (isset($this->phkRequestData['condo_id']) && !isset($this->phkRequestData['fiscal_year_text'])) {
            $this->phkRequestData['fiscal_year_id'] = '';
            $this->phkRequestData['fiscal_year_text'] = '';
            $this->phkRequestData['has_fiscal_year'] = false;
            App::import("Model", "FiscalYear");
            $fiscalYear = new FiscalYear();
            $fiscalYearResult = $fiscalYear->find("first", array('conditions' => array('FiscalYear.active' => 1, 'FiscalYear.condo_id' => $this->phkRequestData['condo_id'])));
            if (count($fiscalYearResult)) {
                $this->phkRequestData['fiscal_year_id'] = $fiscalYearResult['FiscalYear']['id'];
                $this->phkRequestData['fiscal_year_text'] = $fiscalYearResult['FiscalYear']['title'];
                $this->phkRequestData['has_fiscal_year'] = true;
            }
        }
    }

    private function setAccountData() {
        if (isset($this->phkRequestData['account_id']) && !isset($this->phkRequestData['account_text'])) {
            App::import("Model", "Account");
            $account = new Account();
            $result = $account->find("first", array('conditions' => array('Account.id' => $this->phkRequestData['account_id'])));
            if (count($result)) {
                $this->phkRequestData['account_id'] = $result['Account']['id'];
                $this->phkRequestData['account_text'] = $result['Account']['title'];
                $this->phkRequestData['condo_id'] = $result['Account']['condo_id'];
            }
        }
    }

    private function setFractionData() {
        if (isset($this->phkRequestData['fraction_id']) && !isset($this->phkRequestData['fraction_text'])) {
            App::import("Model", "Fraction");
            $fraction = new Fraction();
            $result = $fraction->find("first", array('conditions' => array('Fraction.id' => $this->phkRequestData['fraction_id'])));
            if (count($result)) {
                $this->phkRequestData['fraction_id'] = $result['Fraction']['id'];
                $this->phkRequestData['fraction_text'] = $result['Fraction']['description'];
                $this->phkRequestData['condo_id'] = $result['Fraction']['condo_id'];
            }
        }
    }

    private function setOwnerData() {
        if (isset($this->phkRequestData['owner_id']) && !isset($this->phkRequestData['owner_text'])) {
            App::import("Model", "Entity");
            $entity = new Entity();
            $result = $entity->find("first", array('conditions' => array('Entity.id' => $this->phkRequestData['owner_id'])));
            if (count($result)) {
                $this->phkRequestData['owner_id'] = $result['Entity']['id'];
                $this->phkRequestData['owner_text'] = $result['Entity']['name'];
            }
        }
    }

    private function setSupplierData() {
        if (isset($this->phkRequestData['supplier_id']) && !isset($this->phkRequestData['supplier_text'])) {
            App::import("Model", "Supplier");
            $supplier = new Supplier();
            $result = $supplier->find("first", array('conditions' => array('Supplier.id' => $this->phkRequestData['supplier_id'])));
            if (count($result)) {
                $this->phkRequestData['supplier_id'] = $result['Supplier']['id'];
                $this->phkRequestData['supplier_text'] = $result['Supplier']['name'];
            }
        }
    }

    private function setNoteData() {
        if (isset($this->phkRequestData['note_id']) && !isset($this->phkRequestData['note_text'])) {
            App::import("Model", "Note");
            $note = new Note();
            $result = $note->find("first", array('conditions' => array('Note.id' => $this->phkRequestData['note_id'])));
            if (count($result)) {
                $this->phkRequestData['note_id'] = $result['Note']['id'];
                $this->phkRequestData['note_text'] = $result['Note']['document'];
                $this->phkRequestData['owner_id'] = $result['Note']['entity_id'];
                $this->phkRequestData['fraction_id'] = $result['Note']['fraction_id'];
            }
        }
    }

    private function setReceiptData() {
        if (isset($this->phkRequestData['receipt_id']) && !isset($this->phkRequestData['receipt_text'])) {
            App::import("Model", "Receipt");
            $receipt = new Receipt();
            $result = $receipt->find("first", array('conditions' => array('Receipt.id' => $this->phkRequestData['receipt_id'])));
            if (count($result)) {
                $this->phkRequestData['receipt_id'] = $result['Receipt']['id'];
                $this->phkRequestData['receipt_text'] = $result['Receipt']['document'];
                $this->phkRequestData['owner_id'] = $result['Receipt']['client_id'];
                $this->phkRequestData['fraction_id'] = $result['Receipt']['fraction_id'];
                $this->phkRequestData['condo_id'] = $result['Receipt']['condo_id'];
            }
        }
    }

    private function setAdministratorData() {
        if (isset($this->phkRequestData['administrator_id']) && !isset($this->phkRequestData['administrator_text'])) {
            App::import("Model", "Administrator");
            $administrator = new Administrator();
            $administrator->contain('Entity');
            $result = $administrator->find("first", array('conditions' => array('Administrator.id' => $this->phkRequestData['administrator_id'])));
            $this->phkRequestData['administrator_id'] = $result['Administrator']['id'];
            $this->phkRequestData['administrator_text'] = $result['Entity']['name'];
        }
    }

    private function setInvoiceData() {
        if (isset($this->phkRequestData['invoice_id']) && !isset($this->phkRequestData['invoice_text'])) {
            App::import("Model", "InvoiceConference");
            $invoice = new InvoiceConference();
            $result = $invoice->find("first", array('conditions' => array('InvoiceConference.id' => $this->phkRequestData['invoice_id'])));
            $this->phkRequestData['invoice_id'] = $result['InvoiceConference']['id'];
            $this->phkRequestData['invoice_text'] = $result['InvoiceConference']['description'] . ' ( ' . $result['InvoiceConference']['document'] . ' ) ';
            $this->phkRequestData['supplier_id'] = $result['InvoiceConference']['supplier_id'];
        }
    }

    private function setMaintenanceData() {
        if (isset($this->phkRequestData['maintenance_id']) && !isset($this->phkRequestData['maintenance_text'])) {
            App::import("Model", "Maintenance");
            $maintenance = new Maintenance();
            $result = $maintenance->find("first", array('conditions' => array('Maintenance.id' => $this->phkRequestData['maintenance_id'])));
            if (count($result)) {
                $this->phkRequestData['maintenance_id'] = $result['Maintenance']['id'];
                $this->phkRequestData['maintenance_text'] = $result['Maintenance']['title'];
            }
        }
    }

    private function setInsuranceData() {
        if (isset($this->phkRequestData['insurance_id']) && !isset($this->phkRequestData['insurance_text'])) {
            App::import("Model", "Insurance");
            $insurance = new Insurance();
            $result = $insurance->find("first", array('conditions' => array('Insurance.id' => $this->phkRequestData['insurance_id'])));
            if (count($result)) {
                $this->phkRequestData['insurance_id'] = $result['Insurance']['id'];
                $this->phkRequestData['insurance_text'] = $result['Insurance']['title'];
            }
        }
    }

    private function setBudgetData() {
        if (isset($this->phkRequestData['budget_id']) && !isset($this->phkRequestData['budget_text'])) {
            App::import("Model", "Budget");
            $budget = new Budget();
            $result = $budget->find("first", array('conditions' => array('Budget.id' => $this->phkRequestData['budget_id'])));
            if (count($result)) {
                $this->phkRequestData['budget_id'] = $result['Budget']['id'];
                $this->phkRequestData['budget_text'] = $result['Budget']['title'];
                $this->phkRequestData['budget_status'] = $result['Budget']['budget_status_id'];
                $this->phkRequestData['condo_id'] = $result['Budget']['condo_id'];
            }
        }
    }

    private function getTheme() {
        return Configure::read('Theme.name');
    }

}
