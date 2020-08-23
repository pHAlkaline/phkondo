<?php

App::uses('AppModel', 'Model');

/**
 * InvoiceConferenceStatus Model
 *
 */
class InvoiceConferenceStatus extends AppModel {

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
    public $order = array("InvoiceConferenceStatus.name" => "ASC");

}
