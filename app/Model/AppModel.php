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
App::uses('Model', 'Model');

class AppModel extends Model {
    public $recursive = -1;
    public $actsAs = array('DateFormat' => array(
            'dateFormat' => 'Y-m-d',
            'databaseFormat' => 'Y-m-d',
        ),
        'Containable');
    public $validationDomain = 'validation';

    public function __construct($id = false, $table = null, $ds = null) {
        $this->actsAs['DateFormat']['dateFormat'] = Configure::read('dateFormatSimple');
        $this->actsAs['DateFormat']['databaseFormat'] = Configure::read('databaseDateFormat');
        parent::__construct($id, $table, $ds);
    }

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
    
    public function beforeDelete($cascade = true) {
        if (!$this->canDelete($this->id)){
            return false;
        }
        return parent::beforeDelete($cascade);
    }
    
    public function canDelete($id){
        
        $this->name;
        $this->id=$id;
        $canDelete = true;
        foreach ($this->hasMany as $model => $details) {

            if ($details['dependent'] !== true && $model !== 'Comment') {
                if ($details['className'] == $this->name) {
                    $ModelInstance = $this;
                } else {
                    $ModelInstance = $this->{$model};
                }
                $ModelInstance->contain();
                $count = $ModelInstance->find("count", array(
                    "conditions" => array($details['foreignKey'] => $this->id)
                ));
                if ($count) {
                    $canDelete = false;
                }
            }
        }
        foreach ($this->hasAndBelongsToMany as $model => $details) {
            
            if (isset($details['dependent']) && $details['dependent']==true) {
                return $canDelete;
            }
            
            if ($details['with'] == $this->name) {
                $ModelInstance = $this;
            } else {
                $ModelInstance = $this->{$details['with']};
            }
            $ModelInstance->contain();
            $count = $ModelInstance->find("count", array(
                "conditions" => array($details['foreignKey'] => $this->id)
            ));
            if ($count) {
                $canDelete = false;
            }
        }
        return $canDelete;
    }

}
