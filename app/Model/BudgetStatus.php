<?php

App::uses('AppModel', 'Model');

/**
 * BudgetStatus Model
 *
 */
class BudgetStatus extends AppModel {

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
    public $order = array("BudgetStatus.name" => "ASC");

}
