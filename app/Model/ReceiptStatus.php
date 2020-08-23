<?php

App::uses('AppModel', 'Model');

/**
 * ReceiptStatus Model
 *
 */
class ReceiptStatus extends AppModel {

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
    public $order = array("ReceiptStatus.name" => "ASC");

}
