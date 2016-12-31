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
 * Fraction Model
 *
 * @property Condo $Condo
 * @property Manager $Manager
 * @property Note $Note
 * @property Entity $Entity
 */
class Fraction extends AppModel {
    
     public $actsAs = array('Feedback.Commentable');

    public $virtualFields = array(
        'length' => 'CHAR_LENGTH(fraction)'
    );

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
    public $order = array('Fraction.length' => 'ASC', 'Fraction.fraction' => 'ASC');

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
        'manager_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'fraction' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'fraction_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
               
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'floor_location' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'mil_rate' => array(
            'maxvalue' => array(
                'rule' => array('range', -0.01, 1000.01),
                'message' => 'Please enter an valid rate.'
            )
        )
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
            'fields' => array('id', 'title'),
            'order' => ''
        ),
        'Manager' => array(
            'className' => 'Entity',
            'foreignKey' => 'manager_id',
            'fields' => array('id', 'name'),
            'order' => ''
        ),
        'FractionType' => array(
            'className' => 'FractionType',
            'foreignKey' => 'fraction_type_id',
            'conditions' => '',
            'fields' => array('id', 'name'),
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Insurance' => array(
            'className' => 'Insurance',
            'foreignKey' => 'fraction_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'Note' => array(
            'className' => 'Note',
            'foreignKey' => 'fraction_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
    ));

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Entity' => array(
            'className' => 'Entity',
            'joinTable' => 'entities_fractions',
            'foreignKey' => 'fraction_id',
            'associationForeignKey' => 'entity_id',
            'unique' => 'keepExisting',
            'fields' => '',
            'order' => array('Entity.name'),
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'dependent' => true
        )
    );

    public function beforeFind($queryData) {
        if (isset($queryData['order'][0]) && is_array($queryData['order'][0])) {
            if (isset($queryData['order'][0]['length']) && !isset($queryData['order'][0]['Fraction.frction'])) {
                $sticky = array('Fraction.fraction' => $queryData['order'][0]['length']);
                $queryData['order'][0] = $queryData['order'][0] + $sticky;
            }
        }
        return $queryData;
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
               if (isset($results[$key]['Fraction']['id'])) {
                    $results[$key]['Fraction']['deletable'] = $this->deletable($results[$key]['Fraction']['id']);
                }
            }
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

        return $result;
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

        $notes = $this->Note->find('count', array('conditions' => array('Note.fraction_id' => $id, 'Note.note_status_id' => array('2', '3'))));
        return ($notes > 0) ? true : false;
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

}
