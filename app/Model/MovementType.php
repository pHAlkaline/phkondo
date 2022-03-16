<?php

App::uses('AppModel', 'Model');

/**
 * MovementType Model
 *
 */
class MovementType extends AppModel {

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
    public $order = array("MovementType.name" => "ASC");
}
