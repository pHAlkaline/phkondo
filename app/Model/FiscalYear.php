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
 * FiscalYear Model
 *
 */
class FiscalYear extends AppModel {

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
    public $order = 'FiscalYear.title';

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
            )
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
        'open_date' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'validInterval' => array(
                'rule' => array('validInterval', 'open_date'),
                'message' => 'invalid open date',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'close_date' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'validInterval' => array(
                'rule' => array('validInterval', 'close_date'),
                'message' => 'invalid close date',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'afterOpenDate' => array(
                'rule' => array('compareDates'),
                'message' => 'close date must be after open date',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'active' => array(
            'boolean' => array(
                'rule' => array('boolean'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'noActive' => array(
                'rule' => array('noActive'),
                'message' => 'invalid active',
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

    function compareDates($data) {
        return CakeTime::fromString($data['close_date']) > CakeTime::fromString($this->data[$this->alias]['open_date']);
    }

    function validInterval($data, $field) {

        $fiscalYearId = null;
        if (isset($this->data[$this->alias]['id']))
            $fiscalYearId = $this->data[$this->alias]['id'];
        
        $open_date=date(Configure::read('databaseDateFormat'), strtotime($this->data[$this->alias]['open_date']));
        $close_date=date(Configure::read('databaseDateFormat'), strtotime($this->data[$this->alias]['close_date']));
        $inInterval = $this->find('count', array('conditions' =>
            array('and' =>
                array('or' =>
                    array(
                        array(' ? between open_date and close_date' => array($open_date)),
                        array(' ? between open_date and close_date' => array($close_date))
                    ),
                    $this->alias . '.condo_id' => $this->data[$this->alias]['condo_id'],
                    $this->alias . '.id <>' => $fiscalYearId))
        ));
        
        if ($inInterval > 0) return false;
        
        $inInterval = $this->find('count', array('conditions' =>
            array('and' =>
                array('or' =>
                    array(
                        array($this->alias . '.open_date between ? and ?' => array($open_date, $close_date)),
                        array($this->alias . '.close_date between ? and ?' => array($open_date, $close_date))
                    ),
                    $this->alias . '.condo_id' => $this->data[$this->alias]['condo_id'],
                    $this->alias . '.id <>' => $fiscalYearId))
        ));
        
        if ($inInterval > 0) return false;
        
        return true;
    }

    function noActive($data) {
        if ($this->data[$this->alias]['active'] == '0') {
            return true;
        }
        $id = null;
        if (isset($this->data[$this->alias]['id'])) {
            $id = $this->data[$this->alias]['id'];
        }
        $hasActive = $this->find('count', array(
            'conditions' => array(
                $this->alias . '.id <>' => $id,
                $this->alias . '.condo_id' => $this->data[$this->alias]['condo_id'], $this->alias . '.active' => '1'),
            'fields' => array('active')));
        return $hasActive < 1;
    }

    function active() {
        $this->read();
        $this->updateAll(
                array($this->alias . '.active' => '0'), array(
            $this->alias . '.id <>' => $this->id,
            $this->alias . '.condo_id' => $this->data[$this->alias]['condo_id'],
            $this->alias . '.active' => '1')
        );
        return $this->saveField('active', '1');
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
        
        if (isset($results[0][$this->alias])) {
            foreach ($results as $key => $val) {
                if (isset($results[$key][$this->alias]['active'])) {
                    $results[$key][$this->alias]['active_string'] = ($results[$key][$this->alias]['active']) ? __('Active') : null;
                }
                if (isset($results[$key]['FiscalYear']['id'])) {
                    $results[$key]['FiscalYear']['deletable'] = $this->deletable($results[$key]['FiscalYear']['id']);
                }
            }
        }
        if (isset($results['active'])) {
            $results['active_string'] = ($results['active']) ? __('Active') : null;
        }
       
        if (isset($results['id'])) {
            $results['deletable'] = $this->deletable($results['id']);
        }

        return $results;
    }

    function beforeDelete($cascade = true) {
        $result = true;
        if ($this->hasPaidNotes($this->id))
            $result = false;
        if ($this->hasMovements($this->id))
            $result = false;
        if ($this->field('active'))
            $result = false;
        
        return $result;
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

        $notes = ClassRegistry::init('Note')->find('count', array('conditions' => array('Note.fiscal_year_id' => $id, 'Note.note_status_id' => array('2', '3'))));
        return ($notes > 0) ? true : false;
    }
    
    function hasMovements($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        $movements = ClassRegistry::init('Movement')->find('count', array('conditions' => array('Movement.fiscal_year_id' => $id)));
        return ($movements > 0) ? true : false;
    }

}
