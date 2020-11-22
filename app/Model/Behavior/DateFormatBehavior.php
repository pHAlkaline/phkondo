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
 * @package       app.Model.Behaviour
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */

/**
 * Description of DateformatBehavior
 *
 * @author pHAlkaline <contact@phalkaline.eu>
 */
class DateformatBehavior extends ModelBehavior {

    //App  format
    var $dateFormat = 'd-m-Y';
    //Database Format
    var $databaseFormat = 'Y-m-d';
    var $date_columns = [];

    function setup(Model $model, $config = array()) {

        if (isset($config['dateFormat'])) {
            $this->dateFormat = $config['dateFormat'];
        }
        if (isset($config['databaseFormat'])) {
            $this->databaseFormat = $config['databaseFormat'];
        }
        $this->model = $model;
        debug($model);
        exit();
        $model_list = App::objects('Model');
        foreach ($model_list as $model) {
            if (in_array($model,['AppModel'])){
                continue;
            }
            $modelClass = ClassRegistry::init($model);
            $columns = $modelClass->getColumnTypes();
            //use only date and datetime columns
            foreach ($columns as $column => $type) {
                if (($type != 'date') && ($type != 'datetime'))
                    unset($columns[$column]);
            }
            $this->date_columns=array_merge($this->date_columns,$columns);
        }
       
    }

    function _changeDateFormat($date = null, $dateFormat) {
        return date($dateFormat, strtotime($date));
    }

    function _setValidationFormat($column = null) {
        $field = $this->model->validator()->getField($column);
        if (!is_null($field)) {
            $rule = $field->getRule('date');
            if (!is_null($rule)) {
                $field->setRule('date', array('rule' => array('date', strtolower(str_replace(array('-', '/'), '', $this->dateFormat)))));
            }
        }
    }

    //This function search an array to get a date or datetime field. 
    function _changeDate($queryDataConditions, $dateFormat) {
        if (!$queryDataConditions || !is_array($queryDataConditions))
            return $queryDataConditions;
        foreach ($queryDataConditions as $key => $value) {
            if (is_array($value)) {
                $queryDataConditions[$key] = $this->_changeDate($value, $dateFormat);
            } else {

                //we look for date or datetime fields on database model 
                foreach ($this->date_columns as $column => $type) {
                    if (($key === $column || strpos($key, $this->model->alias . '.' . $column) !== false) && $value != null) {
                        if ($type == 'datetime')
                            $queryDataConditions[$key] = $this->_changeDateFormat($value, $dateFormat . ' H:i:s');
                        if ($type == 'date') {
                            $queryDataConditions[$key] = $this->_changeDateFormat($value, $dateFormat);
                        }
                    }
                }
            }
        }

        return $queryDataConditions;
    }

    function _changeValidation() {
        $columns = $this->model->getColumnTypes();
        //use only date and datetime columns
        foreach ($columns as $column => $type) {
            if (($type != 'date') && ($type != 'datetime'))
                unset($columns[$column]);
        }

        //we look for date or datetime fields on database model 
        foreach ($columns as $column => $type) {


            if ($type == 'datetime' || $type == 'date') {
                $this->_setValidationFormat($column);
            }
        }
    }

    function beforeFind(Model $model, $queryData = array()) {
        $this->model = $model;
        $queryData['conditions'] = $this->_changeDate($queryData['conditions'], $this->databaseFormat);
        return $queryData;
    }

    function afterFind(Model $model, $results, $primary = false) {
        $this->model = $model;
        $results = $this->_changeDate($results, $this->dateFormat);
        return $results;
    }

    function beforeSave(Model $model, $options = array()) {
        $this->model = $model;
        $model->data = $this->_changeDate($model->data, $this->databaseFormat);
        return true;
    }

    function beforeValidate(Model $model, $options = array()) {
        $this->model = $model;
        $this->_changeValidation();
    }

}

?>
