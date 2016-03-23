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
            'notBlank' => array(
                'rule' => array('notBlank'),
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
                'rule' => array('date'),
                'allowEmpty' => true,
                'required' => false,
            ),
            'after_start_date' => array(
                'rule' => array('checkAfterStartDate'),
                'message' => 'Renewal date must be after start date',
                'allowEmpty' => true,
                'required' => false,
            ),
        ),
        'last_inspection' => array(
            'date' => array(
                'rule' => array('date'),
                'allowEmpty' => true,
                'required' => false,
            ),
            'checkPastDate' => array(
                'rule' => array('checkPastDate'),
                'message' => 'invalid date',
                'allowEmpty' => true,
                'required' => false,
            ),
        ),
        'next_inspection' => array(
            'date' => array(
                'rule' => array('date'),
                'allowEmpty' => true,
                'required' => false,
            ),
            'after_start_date' => array(
                'rule' => array('checkAfterStartDate'),
                'message' => 'Next inspection date must be after start date',
                'allowEmpty' => true,
                'required' => false,
            ),
            'after_last_inspection_date' => array(
                'rule' => array('checkAfterLastInspectionDate'),
                'message' => 'Next inspection date must be after last inspection date',
                'allowEmpty' => true,
                'required' => false,
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
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
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

}
