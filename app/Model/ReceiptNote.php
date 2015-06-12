<?php
/**
 *
 * pHKondo : pHKondo software for condominium property managers (http://phalkaline.eu)
 * Copyright (c) pHAlkaline . (http://phalkaline.eu)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @copyright     Copyright (c) pHAlkaline . (http://phalkaline.eu)
 * @link          http://phkondo.net pHKondo Project
 * @package       app.Model
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */

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
