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
 * @package       app.Model
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */

App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');

/**
 * Movement Model
 *
 * @property Account $Account
 * @property MovementCategory $MovementCategory
 * @property MovementOperation $MovementOperation
 */
class Movement extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'description';
    
    /**
     * Order
     *
     * @var string
     */
    public $order = array('Movement.movement_date'=>'DESC','Movement.id'=>'DESC');

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'account_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'fiscal_year_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'movement_date' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'validInterval' => array(
                'rule' => array('validInterval'),
                'message' => 'invalid date, do not match active fiscal year dates',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            /*'future' => array(
                'rule' => array('checkPastDate'),
                'message' => 'invalid origin date'
            )*/
        ),
        'description' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'amount' => array(
            'money' => array(
                'rule' => array('money'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        /* 'balance' => array(
          'money' => array(
          'rule' => array('money'),
          //'message' => 'Your custom message here',
          //'allowEmpty' => false,
          //'required' => false,
          //'last' => false, // Stop validation after this rule
          //'on' => 'create', // Limit validation to 'create' or 'update' operations
          ),
          ), */
        'movement_category_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'movement_operation_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'movement_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Account' => array(
            'className' => 'Account',
            'foreignKey' => 'account_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'FiscalYear' => array(
            'className' => 'FiscalYear',
            'foreignKey' => 'fiscal_year_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'MovementCategory' => array(
            'className' => 'MovementCategory',
            'foreignKey' => 'movement_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'MovementOperation' => array(
            'className' => 'MovementOperation',
            'foreignKey' => 'movement_operation_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'MovementType' => array(
            'className' => 'MovementType',
            'foreignKey' => 'movement_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    
    
    /**
     * validInterval
     * Custom Validation Rule: Ensures a selected date is in valud interval
     *
     * @param array $data Contains the value passed from the view to be validated
     * @return bool True if in interval, False otherwise
     */
    function validInterval($data) {
        $fiscalYear = ClassRegistry::init('FiscalYear');
        $fiscalYearCount = $fiscalYear->find('count', array('conditions' => array('and' => array('FiscalYear.open_date <=' => $data['movement_date'], 'FiscalYear.close_date >=' => $data['movement_date'], 'FiscalYear.id' => $this->data[$this->alias]['fiscal_year_id']))));
        return $fiscalYearCount > 0;
    }

    /**
     * checkPastDate
     * Custom Validation Rule: Ensures a selected date is either the
     * present day or in the past.
     *
     * @param array $check Contains the value passed from the view to be validated
     * @return bool True if in the past or today, False otherwise
     */
    public function checkPastDate($check) {
        $value = array_values($check);
        return CakeTime::fromString($value['0']) <= CakeTime::fromString(date(Configure::read('databaseDateFormat')));
    }
    
    
    public function afterSave($created=null, $options = array()) {
        $account_id = $this->field('account_id');
        $fiscal_year_id = $this->field('fiscal_year_id');
        $this->Account->setAccountBalanceByFiscalYear($account_id,$fiscal_year_id);
        
    }
    
    public function afterDelete(){
        if (!isset($this->data['Movement'])){ return; }
        $account_id = $this->data['Movement']['account_id'];
        $fiscal_year_id = $this->data['Movement']['fiscal_year_id'];
        $this->Account->setAccountBalanceByFiscalYear($account_id,$fiscal_year_id);
        
    }
    
    
    
    public function deletable(){
        if ($this->id==null){ return false; }
        if (!isset($this->data['Movement']['id'])){
            $this->read();
        }
        
        $conditions = array(
            'fiscal_year_id' => $this->data['Movement']['fiscal_year_id'],
            'account_id' => $this->data['Movement']['account_id']
                );
        $totalMovements = $this->find('count', array('conditions' => $conditions));
        if ($totalMovements==1){ return true; }
        
        return $this->data['Movement']['movement_operation_id'] != 1;
    }
    
    

}
