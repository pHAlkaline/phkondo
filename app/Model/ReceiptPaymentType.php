<?php

App::uses('AppModel', 'Model');

/**
 * ReceiptPaymentType Model
 *
 */
class ReceiptPaymentType extends AppModel {

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
    public $order = array("ReceiptPaymentType.name" => "ASC");

}
