<?php

App::uses('AppModel', 'Model');

/**
 * ReceiptNote Model
 *
 * @property NoteType $NoteType
 * @property Fraction $Fraction
 * @property FiscalYear $FiscalYear
 * @property NoteStatus $NoteStatus
 */
class ReceiptNote extends AppModel {
    public $actsAs = array('Containable');

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * order field
     *
     * @var string
     */
    public $order = array("ReceiptNote.document_date" => "asc", "ReceiptNote.document" => "asc");

   

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'NoteType' => array(
            'className' => 'NoteType',
            'foreignKey' => 'note_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Fraction' => array(
            'className' => 'Fraction',
            'foreignKey' => 'fraction_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'FiscalYear' => array(
            'className' => 'FiscalYear',
            'foreignKey' => 'fiscal_year_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Entity' => array(
            'className' => 'Entity',
            'foreignKey' => 'entity_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Budget' => array(
            'className' => 'Budget',
            'foreignKey' => 'budget_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'NoteStatus' => array(
            'className' => 'NoteStatus',
            'foreignKey' => 'note_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Receipt' => array(
            'className' => 'Receipt',
            'foreignKey' => 'receipt_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

   
}
