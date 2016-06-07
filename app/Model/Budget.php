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
 * Budget Model
 *
 * @property Condo $Condo
 * @property FiscalYear $FiscalYear
 * @property BudgetType $BudgetType
 * @property BudgetStatus $BudgetStatus
 * @property SharePeriodicity $SharePeriodicity
 * @property ShareDistribution $ShareDistribution
 */
class Budget extends AppModel {

    private $noAfterFind = false;

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
    public $order = 'Budget.title';

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
        'budget_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'budget_status_id' => array(
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
        'budget_date' => array(
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
        'common_reserve_fund' => array(
            'maxvalue' => array(
                'rule' => array('range', -0.01, 100.01),
                'message' => 'Please enter an valid percentage.',
                'required' => false
            )
        ),
        'begin_date' => array(
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
        ),
        'shares' => array(
            'numeric' => array(
                'rule' => 'naturalNumber',
                
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'share_periodicity_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'share_distribution_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'due_days' => array(
            'numeric' => array(
                'rule' => 'naturalNumber',
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
        'FiscalYear' => array(
            'className' => 'FiscalYear',
            'foreignKey' => 'fiscal_year_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'BudgetType' => array(
            'className' => 'BudgetType',
            'foreignKey' => 'budget_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'BudgetStatus' => array(
            'className' => 'BudgetStatus',
            'foreignKey' => 'budget_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SharePeriodicity' => array(
            'className' => 'SharePeriodicity',
            'foreignKey' => 'share_periodicity_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ShareDistribution' => array(
            'className' => 'ShareDistribution',
            'foreignKey' => 'share_distribution_id',
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
            'foreignKey' => 'budget_id',
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
    );

    /**
     * validInterval
     * Custom Validation Rule: Ensures a selected date is in valud interval
     *
     * @param array $data Contains the value passed from the view to be validated
     * @return bool True if in interval, False otherwise
     */
    function validInterval($validate) {
        foreach ($validate as $key => $data)
            $fiscalYear = ClassRegistry::init('FiscalYear');
        $fiscalYearCount = $fiscalYear->find('count', array('conditions' => array('and' => array('FiscalYear.open_date <=' => $data, 'FiscalYear.close_date >=' => $data, 'FiscalYear.id' => $this->data[$this->alias]['fiscal_year_id']))));

        return $fiscalYearCount > 0;
    }

    function beforeDelete($cascade = true) {
        $result = true;
        if ($this->field('budget_status_id') != '1')
            $result = false;

        if ($this->hasPaidNotes($this->id))
            $result = false;

        return $result;
    }

    function editable($id = null) {
        $this->noAfterFind = true;

        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        $fiscalYear = $this->Condo->FiscalYear->find("first", array('conditions' => array('FiscalYear.active' => 1, 'FiscalYear.condo_id' => $this->field('condo_id'))));

        return ($this->field('fiscal_year_id') == $fiscalYear['FiscalYear']['id']);
    }

    function deletable($id = null) {
        $this->noAfterFind = true;

        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        return $this->beforeDelete(false);
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

        $notes = $this->Note->find('count', array('conditions' => array('Note.budget_id' => $id, 'Note.note_status_id' => array('2', '3'))));
        return ($notes > 0) ? true : false;
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
            $this->noAfterFind = false;
            return $results;
        }

        if (isset($results[0]['Budget'])) {
            foreach ($results as $key => $val) {
                if (isset($results[$key]['Budget']['id'])) {
                    $results[$key]['Budget']['deletable'] = $this->deletable($results[$key]['Budget']['id']);
                    $results[$key]['Budget']['editable'] = $this->editable($results[$key]['Budget']['id']);
                }
            }
        }
        if (isset($results['id'])) {
            $results['deletable'] = $this->deletable($results['id']);
            $results['editable'] = $this->editable($results['id']);
        }

        return $results;
    }

}
