<?php

App::uses('AppModel', 'Model');

/**
 * Account Model
 *
 * @property Condo $Condo
 */
class Account extends AppModel {
    
    

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
    public $order = 'Account.title';

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
        'bank' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'balcony' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'contacts' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'account_number' => array(
            'uuid' => array(
                'rule' => array('isUnique'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'nib' => array(
            'uuid' => array(
                'rule' => array('isUnique'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'main_account' => array(
            'boolean' => array(
                'rule' => array('boolean'),
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
        'Condo' => array(
            'className' => 'Condo',
            'foreignKey' => 'condo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'FiscalYear' => array(
            'className' => 'FiscalYear',
            'joinTable' => 'accounts_fiscal_years',
            'foreignKey' => 'account_id',
            'associationForeignKey' => 'fiscal_year_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );
    
    
    public function setAccountBalanceByFiscalYear($id=null,$fiscal_year_id=null){
        if ($id != null && $fiscal_year_id!= null) {
            $this->Movement=  ClassRegistry::init('Movement');
            $totalDebit = $this->Movement->find('first', array('fields' =>
                array('SUM(amount) AS total'),
                'conditions' => array('account_id' => $id,'fiscal_year_id' => $fiscal_year_id, 'movement_type_id' => '1')
                    )
            );
            $totalCredit = $this->Movement->find('first', array('fields' =>
                array('SUM(amount) AS total'),
                'conditions' => array('account_id' => $id,'fiscal_year_id' => $fiscal_year_id, 'movement_type_id' => '2')
                    )
            );
            $total = $totalDebit[0]['total'] - $totalCredit[0]['total'];
            $accountBalance=$this->AccountsFiscalYear->find('first',
                    array('conditions' => 
                        array('account_id' => $id,'fiscal_year_id' => $fiscal_year_id)));
            if (count($accountBalance)==0){
                $accountBalance['AccountsFiscalYear']['account_id']=$id;
                $accountBalance['AccountsFiscalYear']['fiscal_year_id']=$fiscal_year_id;
                $this->AccountsFiscalYear->create();
            }
            $accountBalance['AccountsFiscalYear']['balance']=$total;
            $this->AccountsFiscalYear->save($accountBalance);
            
            $this->id = $id;
            $this->saveField('balance', $total);
        }
    }


}
