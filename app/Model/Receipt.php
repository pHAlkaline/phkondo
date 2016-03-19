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
 * Receipt Model
 *
 * @property Condo $Condo
 * @property Client $Client
 * @property ReceiptStatus $ReceiptStatus
 * @property Note $Note
 */
class Receipt extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * Order
     *
     * @var string
     */
    public $order = array('Receipt.document_date' => 'DESC', 'Receipt.document' => 'DESC');

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'document' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'condo_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'fraction_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'client_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'total_amount' => array(
            'money' => array(
                'rule' => array('money'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'title' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'document_date' => array(
            'date' => array(
                'rule' => array('date'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'receipt_status_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'receipt_payment_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'payment_date' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            'allowEmpty' => true,
            'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'checkPastDate' => array(
                'rule' => array('checkPastDate'),
                'message' => 'invalid date',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'checkDocumentDate' => array(
                'rule' => array('checkDocumentDate'),
                'message' => 'payment date must be at or after document date',
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
        'Condo' => array(
            'className' => 'Condo',
            'foreignKey' => 'condo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Fraction' => array(
            'className' => 'Fraction',
            'foreignKey' => 'fraction_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Client' => array(
            'className' => 'Entity',
            'foreignKey' => 'client_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ReceiptStatus' => array(
            'className' => 'ReceiptStatus',
            'foreignKey' => 'receipt_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ReceiptPaymentType' => array(
            'className' => 'ReceiptPaymentType',
            'foreignKey' => 'receipt_payment_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'PaymentUser' => array(
            'className' => 'User',
            'foreignKey' => 'payment_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'CancelUser' => array(
            'className' => 'User',
            'foreignKey' => 'cancel_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Note' => array(
            'className' => 'Note',
            'foreignKey' => 'receipt_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'ReceiptNote' => array(
            'className' => 'ReceiptNote',
            'foreignKey' => 'receipt_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    
     /**
     * checkDocumentDate
     * Custom Validation Rule: Ensures a selected date is after Document Date
     * 
     *
     * @param array $check Contains the value passed from the view to be validated
     * @return bool True if in the past or today, False otherwise
     */
    public function checkDocumentDate($check) {
        if (!isset($this->data[$this->alias]['document_date'])){
            $this->data[$this->alias]['document_date']=$this->field('document_date');
        }
        $value = array_values($check);
        return (CakeTime::fromString($this->data[$this->alias]['document_date']) <= CakeTime::fromString($value[0])) ;
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
        return (CakeTime::fromString($value[0]) <= CakeTime::fromString(date(Configure::read('databaseDateFormat'))));
    }

    /**
     * afterFind callback
     * 
     * @param array $results
     * @param boolean $primary
     * @access public
     * @return array
     */
    public function afterFind($results, $primary = false) {
        if ($this->noAfterFind) {
            $this->noAfterFind=false;
            return $results;
        }
        
        
        if (isset($results[0][$this->alias])) {
            foreach ($results as $key => $val) {
                if (isset($results[$key][$this->alias]['id'])) {
                    
                    $results[$key][$this->alias]['payable'] = $this->payable($results[$key][$this->alias]['id']);
                    $results[$key][$this->alias]['editable'] = $this->editable($results[$key][$this->alias]['id']);
                    $results[$key][$this->alias]['deletable'] = $this->deletable($results[$key][$this->alias]['id']);
                    $results[$key][$this->alias]['closeable'] = $this->closeable($results[$key][$this->alias]['id']);
                    $results[$key][$this->alias]['cancelable'] = $this->cancelable($results[$key][$this->alias]['id']);
                    
                }
            }
        }
        
        if (isset($results['id'])) {
            $results['payable'] = $this->payable($results['id']);
            $results['editable'] = $this->editable($results['id']);
            $results['deletable'] = $this->deletable($results['id']);
            $results['closeable'] = $this->closeable($results['id']);
            $results['cancelable'] = $this->cancelable($results['id']);
        }
        
        return $results;
    }

    function beforeDelete($cascade = true) {
        
        if ($this->field('receipt_status_id') == '3')
            return false;
            
        if ($this->hasPaidNotes($this->id))
            return false;

        return true;
    }

    function hasPaidNotes($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        $notes = $this->Note->find('count', array('conditions' => array('Note.receipt_id' => $id, 'Note.note_status_id' => array('2', '3'))));
        return ($notes > 0) ? true : false;
    }

    public function payable($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        if ($this->field('receipt_status_id') == '2') {
            return true;
        }
        return false;
    }

    public function editable($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        if ($this->field('receipt_status_id') > '2') {
            return false;
        }
        return true;
    }

    public function deletable($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        return $this->beforeDelete();
    }

    public function closeable($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        if ($this->field('receipt_status_id') != '3') {
            return false;
        }
        
        $this->noAfterFind = true;
        if ($this->field('receipt_payment_type_id') == '') {
            return false;
        }
        return true;
    }

    public function cancelable($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        if (in_array($this->field('receipt_status_id'), array('1','2', '4'))) {
            return false;
        }
        return true;
    }

}
