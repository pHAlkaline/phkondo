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
App::uses('Note', 'Model');

/**
 * Condo Model
 *
 * @property Account $Account
 * @property Fraction $Fraction
 * @property Maintenance $Maintenance
 */
class Condo extends AppModel {

    public $actsAs = array( 'Containable','Feedback.Commentable');

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
    public $order = 'Condo.title';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
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
        'taxpayer_number' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'email' => array(
            'email' => array(
                'rule' => array('email'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'address' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
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
    public $hasOne = array('ReceiptCounter');

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Account' => array(
            'className' => 'Account',
            'foreignKey' => 'condo_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Fraction' => array(
            'className' => 'Fraction',
            'foreignKey' => 'condo_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => array('Fraction.length' => 'ASC', 'Fraction.fraction' => 'ASC'),
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Maintenance' => array(
            'className' => 'Maintenance',
            'foreignKey' => 'condo_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Insurance' => array(
            'className' => 'Insurance',
            'foreignKey' => 'condo_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'FiscalYear' => array(
            'className' => 'FiscalYear',
            'foreignKey' => 'condo_id',
            'dependent' => true,
            'conditions' => array('FiscalYear.active' => '1'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Administrator' => array(
            'className' => 'Administrator',
            'foreignKey' => 'condo_id',
            'dependent' => true,
        ),
       
    );

    public function hasSharesDebt($id = null) {
        $options = array('conditions' => array('Condo.' . $this->primaryKey => $id));
        $this->contain('Fraction');
        $condo = $this->find('first', $options);
        $fractions = Set::extract('/Fraction/id', $condo);
        $Note = new Note();
        return $hasSharesDebt = $Note->find('count', array(
            'conditions' => array(
                'Note.fraction_id' => $fractions,
                'Note.note_type_id =' => 2,
                'Note.note_status_id <' => 3,
                'Note.document_date < NOW()'),
        ));
    }

    public function hasNegativeAccounts($id = null) {
        $options = array('conditions' => array('Condo.' . $this->primaryKey => $id, 'Account.balance <' => '0'));
        $this->contain('Account');
        $condo = $this->find('first', $options);
        return $result;
    }

    function beforeDelete($cascade = true) {
        $this->cleanNotes();
        ClassRegistry::init('Receipt')->deleteAll(array('Receipt.condo_id' => $this->id));
        return true;
    }

    function cleanNotes($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        $fractions = ClassRegistry::init('Fraction')->find('list', array('conditions' => array('Fraction.condo_id' => $id)));
        $fractions = array_keys($fractions);
        $notes = ClassRegistry::init('Note')->deleteAll(array('Note.fraction_id' => $fractions));
        $receipts = ClassRegistry::init('Receipt')->find('list', array('fields' => array('id', 'id'), 'conditions' => array('Receipt.condo_id' => $id)));
        $receipts = array_keys($receipts);
        $notes = ClassRegistry::init('Note')->deleteAll(array('Note.receipt_id' => $receipts));
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

        $fiscalYears = ClassRegistry::init('FiscalYear')->find('list', array('conditions' => array('FiscalYear.condo_id' => $id)));
        $fiscalYears = array_keys($fiscalYears);
        $notes = ClassRegistry::init('Note')->find('count', array('conditions' => array('Note.fiscal_year_id' => $fiscalYears, 'Note.note_status_id' => array('2', '3'))));
        return ($notes > 0) ? true : false;
    }

    
    
    public function beforeSave($options = array()){
        //debug($this->Behaviors->Upload->settings[$this->alias]['photo']['path']);
        parent::beforeSave($options);
    }
    
   
}
