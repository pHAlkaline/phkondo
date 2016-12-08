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
 * Entity Model
 */
class Entity extends AppModel {
    
     public $actsAs = array('Feedback.Commentable');

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Order
     *
     * @var string
     */
    public $order = 'Entity.name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
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
     * haOne associations
     *
     * @var array
     */
    public $hasOne = array('User'=>[
            'foreignKey' => 'foreign_key',
            'conditions' => ['User.model' => 'Entity'],
            'dependent' => true,
        ]);
    
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
                if (isset($results[$key][$this->alias]['id'])) {
                    $results[$key][$this->alias]['deletable'] = $this->deletable($results[$key][$this->alias]['id']);
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

    function beforeDelete($cascade = true) {
        if ($this->hasNotes($this->id)) {
            return false;
        }
        if ($this->hasReceipts($this->id)) {
            return false;
        }
        if ($this->hasFractions($this->id)) {
            return false;
        }
        if ($this->hasFractionManager($this->id)) {
            return false;
        }
        if ($this->hasAdministrators($this->id)) {
            return false;
        }
        
        return true;
    }

    public function hasNotes($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        $result = ClassRegistry::init('Note')->find('count', array('conditions' => array('Note.entity_id' => $id)));
        return ($result > 0) ? true : false;
    }

    public function hasReceipts($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        $this->alias = 'Entity';
        $result = ClassRegistry::init('Receipt')->find('count', array('conditions' => array('Receipt.client_id' => $id)));
        return ($result > 0) ? true : false;
    }

    public function hasFractions($id = null) {


        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        $this->alias = 'Entity';

        $options['joins'] = array(
            array('table' => 'entities_fractions',
                'alias' => 'EntityFraction',
                'type' => 'INNER',
                'conditions' => array(
                    'Entity.id = EntityFraction.entity_id',
                )
        ));

        $options['conditions'] = array(
            'EntityFraction.entity_id' => $id);

        $result = $this->find('count', $options);
        return ($result > 0) ? true : false;
    }

    public function hasFractionManager($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        $this->Fraction = ClassRegistry::init('Fraction');
        $result = $this->Fraction->find('count', array('conditions' => array('Fraction.manager_id' => $id)));
        return ($result > 0) ? true : false;
    }
    
    public function hasAdministrators($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        $result = ClassRegistry::init('Administrator')->find('count', array('conditions' => array('Administrator.entity_id' => $id)));
        return ($result > 0) ? true : false;
    }

}
