<?php

App::uses('AppModel', 'Model');

/**
 * SharePeriodicity Model
 *
 */
class SharePeriodicity extends AppModel {

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
    public $order = array("SharePeriodicity.name" => "ASC");

}
