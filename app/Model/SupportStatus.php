<?php

App::uses('AppModel', 'Model');

/**
 * SupportStatus Model
 *
 */
class SupportStatus extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Order
     *
     * @var string
     */
    public $order = 'SupportStatus.name';

}
