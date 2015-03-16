<?php

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public $validationDomain='validation';
    //public $recursive = -1;

    public function generateHabtmJoin($joinModel, $joinType = 'INNER') {
        // If the relation does not exist, return an empty array.
        if (!isset($this->hasAndBelongsToMany[$joinModel])) {
            return array();
        }

        // Init joins, and get HABTM relation.
        $joins = array();
        $assoc = $this->hasAndBelongsToMany[$joinModel];

        // Add the join table.
        $bind = "{$assoc['with']}.{$assoc['foreignKey']} = {$this->alias}.{$this->primaryKey}";
        $joins[] = array(
            'table' => $assoc['joinTable'],
            'alias' => $assoc['with'],
            'type' => $joinType,
            'foreignKey' => false,
            'conditions' => array($bind),
        );

        // Add the next table.
        $bind = "{$joinModel}.{$this->{$joinModel}->primaryKey} = {$assoc['with']}.{$assoc['associationForeignKey']}";
        $joins[] = array(
            'table' => $this->{$joinModel}->table,
            'alias' => $joinModel,
            'type' => $joinType,
            'foreignKey' => false,
            'conditions' => array($bind),
        );

        return $joins;
    }

    
}
