<?php

App::uses('AppModel', 'Model');

/**
 * BudgetType Model
 *
 */
class BudgetType extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
     /**
     * order field
     *
     * @var string
     */
    public $order = array("BudgetType.name" => "ASC");

}
