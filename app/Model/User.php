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
App::uses('AuthComponent', 'Controller/Component');
App::uses('AppModel', 'Model');
App::uses('Security', 'Utility');

/**
 * User Model
 *
 */
class User extends AppModel {

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
    public $order = 'User.name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Empty',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'Must be unique',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'username' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Empty',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'Must be unique',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'password' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Empty',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'minimum' => array(
                'rule' => array('minLength', '8'),
                'message' => 'Minimum 8 characters long',
            ),
            'strong' => array(
                'rule' => '/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/i',
                'message' => 'Must contain one upper, one lower, 1 digit or special character',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'verify_password' => array(
            'matchPasswords' => array(
                'rule' => array('matchPasswords'),
                'message' => 'Passwords dont match',
                'required' => false),
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'store_admin', 'colaborator')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        )
    );
    public $hasMany = array(
        'PaidRecipt' => array(
            'className' => 'Receipt',
            'foreignKey' => 'payment_user_id',
        ),
        'CancelRecipt' => array(
            'className' => 'Receipt',
            'foreignKey' => 'cancel_user_id',
        )
    );
    public $belongsTo = array
        ('Entity'=> [
            'foreignKey' => 'foreign_key',
            'conditions' => ['User.model' => 'Entity']
        //'joinType' => 'LEFT'
    ]);

    public function beforeSave($options = array()) {

        // crypt and truncate password
        if (isset($this->data[$this->alias]['password'])) {
            $password = Security::hash(substr($this->data[$this->alias]['password'], 0, 32), null, true);
            $this->data[$this->alias]['password'] = $password;
        }
        // truncate username
        if (isset($this->data[$this->alias]['username'])) {
            $this->data[$this->alias]['username'] = substr($this->data[$this->alias]['username'], 0, 32);
        }
        return true;
    }

    function matchPasswords($data) {

        if ($data['verify_password'] == $this->data[$this->alias]['password']) {
            return true;
        }
        return false;
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
        if (isset($results[0][$this->alias])) {
            foreach ($results as $key => $val) {
                if (isset($results[$key][$this->alias]['id'])) {
                    $results[$key][$this->alias]['deletable'] = $this->canDelete($results[$key][$this->alias]['id']);
                }
            }
        }

        if (isset($results['id'])) {
            $results['deletable'] = $this->canDelete($results['id']);
        }

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

}
