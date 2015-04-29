<?php

App::uses('AppModel', 'Model');

/**
 * Maintenance Model
 *
 * @property Condo $Condo
 * @property Supplier $Supplier
 */
class Maintenance extends AppModel {

    public $virtualFields = array(
        'expire_out' => 'DATEDIFF(NOW(),renewal_date)',
        'next_inspection_out' => 'DATEDIFF(NOW(),next_inspection)',
    );

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'maintenance';

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
    public $order = 'Maintenance.title';

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
        'start_date' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'renewal_date' => array(
            'date' => array(
                'rule' => array('date', 'dmy'),
                'allowEmpty' => true,
                'required' => false,
            ),
            'after_start_date' => array(
                'rule' => array('checkAfterStartDate'),
                'message' => 'Renewal date must be after start date',
            ),
           
        ),
        'next_inspection' => array(
            'date' => array(
                'rule' => array('date', 'dmy'),
                'allowEmpty' => true,
                'required' => false,
            ),
            'after_start_date' => array(
                'rule' => array('checkAfterStartDate'),
                'message' => 'Next inspection date must be after start date',
            ),
            'after_last_inspection_date' => array(
                'rule' => array('checkAfterLastInspectionDate'),
                'message' => 'Next inspection date must be after last inspection date',
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
        'Supplier' => array(
            'className' => 'Entity',
            'foreignKey' => 'supplier_id',
            'conditions' => array('entity_type_id' => '2'),
            'fields' => array('id', 'name'),
            'order' => ''
        ),
    );

    /**
     * afterFind callback
     * 
     * @param array $results
     * @param boolean $primary
     * @access public
     * @return array
     */
    public function afterFind($results, $primary = false) {
        if (isset($results[0][$this->alias]['active'])) {
            foreach ($results as $key => $val) {
                if (isset($results[$key][$this->alias]['active'])) {
                    $results[$key][$this->alias]['active_string'] = ($results[$key][$this->alias]['active']) ? __('Active') : null;
                }
            }
        }
        if (isset($results['active'])) {
            $results['active_string'] = ($results['active']) ? __('Active') : null;
        }
        return $results;
    }

    /**
     * checkAfterStartDate
     * Custom Validation Rule: Ensures a selected date is after start date.
     *
     * @param array $check Contains the value passed from the view to be validated
     * @return bool true if in the past, false otherwise
     */
    public function checkAfterStartDate($check) {
        App::uses('CakeTime', 'Utility');
        $value = array_values($check);
        return CakeTime::fromString($value['0']) > CakeTime::fromString($this->data['Maintenance']['start_date']);
    }

    /**
     * checkAfterLastInspectionDate
     * Custom Validation Rule: Ensures a selected date is after last inspection date case it exists.
     *
     * @param array $check Contains the value passed from the view to be validated
     * @return bool true if in the past, false otherwise
     */
    public function checkAfterLastInspectionDate($check) {
        App::uses('CakeTime', 'Utility');
        $value = array_values($check);
        if (isset($this->data['Maintenance']['last_inspection'])) {
            return CakeTime::fromString($value['0']) > CakeTime::fromString($this->data['Maintenance']['last_inspection']);
        }
        return true;
    }

}
