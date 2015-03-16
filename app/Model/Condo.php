<?php

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

    public $actsAs = array('Containable');

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
            'notempty' => array(
                'rule' => array('notempty'),
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
        'address' => array(
            'notempty' => array(
                'rule' => array('notempty'),
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
        'Fraction' => array(
            'className' => 'Fraction',
            'foreignKey' => 'condo_id',
            'dependent' => false,
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
        'Insurance' => array(
            'className' => 'Insurance',
            'foreignKey' => 'condo_id',
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
        'FiscalYear' => array(
            'className' => 'FiscalYear',
            'foreignKey' => 'condo_id',
            'dependent' => false,
            'conditions' => array('FiscalYear.active' => '1'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    public function hasSharesDebt($id = null) {
        $options = array('conditions' => array('Condo.' . $this->primaryKey => $id));
        $this->contain('Fraction');
        $condo = $this->find('first', $options);
        $fractions = Set::extract('/Fraction/id', $condo);
        $Note = new Note();
        $Note->recursive = -1;
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
        $receipts = ClassRegistry::init('Receipt')->find('list', array('fields'=>array('id','id'),'conditions' => array('Receipt.condo_id' => $id)));
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

}
