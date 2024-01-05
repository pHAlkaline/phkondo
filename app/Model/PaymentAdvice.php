<?php

/**
 *
 * pHKondo : pHKondo software for condominium hoa association management (https://phalkaline.net)
 * Copyright (c) pHAlkaline . (https://phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (https://phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @package       app.Model
 * @since         pHKondo v 1.10.2
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');

/**
 * PaymentAdvice Model
 *
 * @property Condo $Condo
 * @property Entity $Entity
 * @property Note $Note
 */
class PaymentAdvice extends AppModel
{

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
    public $order = array('PaymentAdvice.document_date' => 'DESC', 'PaymentAdvice.document' => 'ASC');

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
        'entity_id' => array(
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
        'document_date' => array(
           'checkDate' => array(
                'rule' => array('date'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'due_date' => array(
            'checkDate' => array(
                 'rule' => array('date'),
                 //'message' => 'Your custom message here',
                 //'allowEmpty' => false,
                 'required' => false,
                 //'last' => false, // Stop validation after this rule
                 //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
        'payment_type_id' => array(
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
            'checkDate' => array(
                'rule' => array('date'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'checkPastDate' => array(
                'rule' => array('checkPastDate'),
                'message' => 'invalid date',
                'allowEmpty' => true,
                'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'checkDocumentDate' => array(
                'rule' => array('checkDocumentDate'),
                'message' => 'payment date must be at or after document date',
                'allowEmpty' => true,
                'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'receipt_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    function isNotPaid($data, $field)
    {
        return $this->data[$this->name]['payment_date'] == null;
    }

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
        'Entity' => array(
            'className' => 'Entity',
            'foreignKey' => 'entity_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'PaymentType' => array(
            'className' => 'ReceiptPaymentType',
            'foreignKey' => 'payment_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Receipt' => array(
            'className' => 'Receipt',
            'foreignKey' => 'receipt_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),


    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Note' => array(
            'className' => 'Note',
            'foreignKey' => 'payment_advice_id',
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

    );

    /**
     * checkDocumentDate
     * Custom Validation Rule: Ensures a selected date is after Document Date
     * 
     *
     * @param array $check Contains the value passed from the view to be validated
     * @return bool True if in the past or today, False otherwise
     */
    public function checkDocumentDate($check)
    {
        if (!isset($this->data[$this->alias]['document_date'])) {
            $this->data[$this->alias]['document_date'] = $this->field('document_date');
        }
        $value = array_values($check);
        return (CakeTime::fromString($this->data[$this->alias]['document_date']) <= CakeTime::fromString($value[0]));
    }

    /**
     * checkPastDate
     * Custom Validation Rule: Ensures a selected date is either the
     * present day or in the past.
     *
     * @param array $check Contains the value passed from the view to be validated
     * @return bool True if in the past or today, False otherwise
     */
    public function checkPastDate($check)
    {
        $value = array_values($check);
        return (CakeTime::fromString($value[0]) <= CakeTime::fromString(date(Configure::read('Application.databaseDateFormat'))));
    }

    /**
     * afterFind callback
     * 
     * @param array $results
     * @param boolean $primary
     * @access public
     * @return array
     */
    public function afterFind($results, $primary = false)
    {
        if ($this->no_after_find) {
            $this->no_after_find = false;
            return $results;
        }


        if (isset($results[0][$this->alias])) {
            foreach ($results as $key => $val) {
                if (isset($results[$key][$this->alias]['id'])) {

                    $results[$key][$this->alias]['payable'] = $this->payable($results[$key][$this->alias]['id']);
                }
            }
        }

        if (isset($results['id'])) {
            $results['payable'] = $this->payable($results['id']);
        }

        return $results;
    }

    public function beforeSave($options = array())
    {
        return true;
    }

    public function afterSave($created, $options = array())
    {
        $result = true;
        if ($created && isset($this->data['PaymentAdvice']['condo_id'])) {
            $number = $this->getNextIndex($this->data['PaymentAdvice']['condo_id']);
            //$result = $result & $this->setIndex($this->data['PaymentAdvice']['condo_id'], $number);
        }


        return $result;
    }

    public function beforeDelete($cascade = true) {
       return true;
    }

    public function afterDelete()
    {
        $this->removeFromNote($this->data['PaymentAdvice']['id']);
        return true;
    }

    public function editable($id = null)
    {
        $this->no_after_find = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        /*if ($this->field('receipt_status_id') > '2') {
            return false;
        }*/
        return true;
    }


    public function payable($id = null)
    {
        $this->no_after_find = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        if ($this->field('payment_date') != null && $this->field('payment_type_id') != null && $this->field('receipt_id') == null) {
            return true;
        }
        return false;
    }

    public function removeFromNote($id)
    {
        return $this->Note->updateAll(array('Note.payment_advice_id' => null, 'Note.note_status_id' => '1', 'Note.pending_amount' => 'Note.amount', 'Note.payment_date' => null), array('Note.payment_advice_id' => $id));
    }

    public function setAmount($id)
    {
        $totalDebit = $this->Note->find(
            'first',
            array(
                'fields' =>
                array('SUM(Note.amount) AS total'),
                'conditions' => array('Note.payment_advice_id' => $id, 'Note.note_type_id' => '2')
            )
        );
        $totalCredit = $this->Note->find(
            'first',
            array(
                'fields' =>
                array('SUM(Note.amount) AS total'),
                'conditions' => array('Note.payment_advice_id' => $id, 'Note.note_type_id' => '1')
            )
        );
        $total = $totalDebit[0]['total'] - $totalCredit[0]['total'];
        $this->id = $id;
        return $this->saveField('total_amount', $total);
    }

    public function getNextIndex($id)
    {
        return CakeText::uuid();
    }
}
