<?php

/**
 * Description of DateformatBehavior
 *
 * @author Paulo Homem <contact@phalkaline.eu>
 */
class DateformatBehavior extends ModelBehavior {

    //App  format
    var $dateFormat = 'd-m-Y';
    //Database Format
    var $databaseFormat = 'Y-m-d';

    function setup(Model $model, $config = array()) {

        if (isset($config['dateFormat'])) {
            $this->dateFormat = $config['dateFormat'];
        }
        if (isset($config['databaseFormat'])) {
            $this->databaseFormat = $config['databaseFormat'];
        }
        $this->model = $model;
    }

    function _changeDateFormat($date = null, $dateFormat) {
        return date($dateFormat, strtotime($date));
    }

    function _setValidationFormat($column=null) {
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
                $columns = $this->model->getColumnTypes();
                //use only date and datetime columns
                foreach ($columns as $column => $type) {
                    if (($type != 'date') && ($type != 'datetime'))
                        unset($columns[$column]);
                }

                //we look for date or datetime fields on database model 
                foreach ($columns as $column => $type) {
                    if (($key === $column || strpos($key, $this->model->alias.'.'.$column)!==false) && $value != null) {
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
