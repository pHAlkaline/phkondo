<?php

App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');

/**
 * InvoiceConference Model
 *
 * @property Condo $Condo
 * @property FiscalYear $FiscalYear
 * @property Entity $Entity
 * @property InvoiceConferenceStatus $InvoiceConferenceStatus
 */
class InvoiceConference extends AppModel {

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
    public $order = array('InvoiceConference.payment_due_date'=>'ASC', 'InvoiceConference.document_date'=>'ASC',);

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
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
        'supplier_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        
        'description' => array(
            'notempty' => array(
                'rule' => array('notempty'),
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
        'document_date' => array(
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
                'message' => 'invalid date',
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
        'payment_due_date' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'validInterval' => array(
                'rule' => array('checkFutureDate'),
                'message' => 'due date must be after document date',
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
        'payment_date' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            'allowEmpty' => true,
            'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'validInterval' => array(
                'rule' => array('checkPastDate'),
                'message' => 'payment date must be after document date',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            
           
        ),
        'invoice_conference_status_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'closedStatus' => array(
                'rule' => array('checkPaymentDate'),
                'message' => 'This status requires payment date',
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
        'FiscalYear' => array(
            'className' => 'FiscalYear',
            'foreignKey' => 'fiscal_year_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'InvoiceConferenceStatus' => array(
            'className' => 'InvoiceConferenceStatus',
            'foreignKey' => 'invoice_conference_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Supplier' => array(
            'className' => 'Entity',
            'foreignKey' => 'supplier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        
    );
    
    
    
    /**
     * validInterval
     * Custom Validation Rule: Ensures a selected date is in valid interval
     *
     * @param array $data Contains the value passed from the view to be validated
     * @return bool True if in interval, False otherwise
     */
    function validInterval($data) {
        $fiscalYear = ClassRegistry::init('FiscalYear');
        $fiscalYearCount = $fiscalYear->find('count', array('conditions' => array('and' => array('FiscalYear.open_date <=' => $data['document_date'], 'FiscalYear.close_date >=' => $data['document_date'], 'FiscalYear.id' => $this->data[$this->alias]['fiscal_year_id']))));
        
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
        return (CakeTime::fromString($this->data[$this->alias]['document_date']) <= CakeTime::fromString($value[0]) && CakeTime::fromString($value[0]) <= CakeTime::fromString(date('Y-m-d')));
    }
    
    /**
     * checkFutureDate
     * Custom Validation Rule: Ensures a selected date is either the
     * present day or in the future.
     *
     * @param array $check Contains the value passed from the view to be validated
     * @return bool True if in the past or today, False otherwise
     */
    public function checkFutureDate($check) {
        
        $value = array_values($check);
        return (CakeTime::fromString($this->data[$this->alias]['document_date']) <= CakeTime::fromString($value[0]));
    }
    
    /**
     * checkPaymentDate
     * Custom Validation Rule: Ensures when selected status ( 5 Paid ) is selected that
     * payment date exists.
     *
     * @param array $check Contains the value passed from the view to be validated
     * @return bool True if in the past or today, False otherwise
     */
    public function checkPaymentDate($check) {
        
        if ($check['invoice_conference_status_id']==5 && $this->data[$this->alias]['payment_date']==''){
            return false;
        }
        return true;
    }
    
    

}
