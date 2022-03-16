<?php

App::uses('AppModel', 'Model');

/**
 * SupportPriority Model
 *
 */
class SupportPriority extends AppModel {

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
    public $order = 'SupportPriority.name';

}
