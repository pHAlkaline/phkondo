<?php

App::uses('AppModel', 'Model');

/**
 * ShareDistribution Model
 *
 */
class ShareDistribution extends AppModel {

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
    public $order = array("ShareDistribution.name" => "ASC");

}
