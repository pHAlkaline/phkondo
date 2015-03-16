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
                    $results[$key][$this->alias]['active_string']= ($results[$key][$this->alias]['active']) ? __('Active') : null;
                }
            }
        }
        if (isset($results['active'])) {
            $results['active_string'] = ($results['active']) ? __('Active') : null;
        }
        return $results;
    }

}
