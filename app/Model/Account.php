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
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'bank' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'balcony' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'contacts' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
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
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Movement' => array(
            'className' => 'Movement',
            'foreignKey' => 'account_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''));

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'FiscalYear' => array(
            'dependent' => true,
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

    public function setAccountBalanceByFiscalYear($id = null, $fiscal_year_id = null) {
        if ($id != null && $fiscal_year_id != null) {
            $this->Movement = ClassRegistry::init('Movement');
            $totalDebit = $this->Movement->find('first', array('fields' =>
                array('SUM(amount) AS total'),
                'conditions' => array('account_id' => $id, 'fiscal_year_id' => $fiscal_year_id, 'movement_type_id' => '1')
                    )
            );
            $totalCredit = $this->Movement->find('first', array('fields' =>
                array('SUM(amount) AS total'),
                'conditions' => array('account_id' => $id, 'fiscal_year_id' => $fiscal_year_id, 'movement_type_id' => '2')
                    )
            );
            $total = $totalDebit[0]['total'] - $totalCredit[0]['total'];
            $accountBalance = $this->AccountsFiscalYear->find('first', array('conditions' =>
                array('account_id' => $id, 'fiscal_year_id' => $fiscal_year_id)));
            if (count($accountBalance) == 0) {
                $accountBalance['AccountsFiscalYear']['account_id'] = $id;
                $accountBalance['AccountsFiscalYear']['fiscal_year_id'] = $fiscal_year_id;
                $this->AccountsFiscalYear->create();
            }
            $accountBalance['AccountsFiscalYear']['balance'] = $total;
            $this->AccountsFiscalYear->save($accountBalance);

            $this->id = $id;
            $this->saveField('balance', $total);
        }
    }


}
