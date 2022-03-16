<?php

App::uses('AppModel', 'Model');

/**
 * NoteStatus Model
 *
 */
class NoteStatus extends AppModel {

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
    public $order = array("NoteStatus.name" => "ASC");

}
