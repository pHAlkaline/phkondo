<?php

/**
 *
 * pHKondo : pHKondo software for condominium hoa association management (https://phalkaline.net)
 * Copyright (c) pHAlkaline . (https://phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (https://phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @package       app.Controller
 * @since         pHKondo v 1.10
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');

/**
 * BudgetNotes Controller
 *
 * @property Note $Note
 * @property PaginatorComponent $Paginator
 */
class NotesController extends AppController
{

    /**
     * Uses
     *
     * @var array
     */
    public $uses = array('Note');

    /**
     * create method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function create()
    {
        if ($this->request->is('post')) {
            set_time_limit(90);
            $notes = $this->request->data['Note'];
            unset($notes['Budget']);
            App::uses('CakeTime', 'Utility');
            foreach ($notes as $key => $note) {
                // check fraction please
                if ($note['selected'] == 0) {
                    continue;
                }
                $this->request->data['Note'] = $note;
                $this->request->data['Note']['note_type_id'] = '2';
                $this->request->data['Note']['pending_amount'] = $note['amount'];
                $shares = 1;
                $tmpDate = $this->request->data['Budget']['begin_date'];
                while ($shares <= $note['shares']) :
                    $month = CakeTime::format('F', $tmpDate);
                    $this->request->data['Note']['title'] = __n('Share', 'Shares', 1) . ' ' . $shares . ' ' . __($month) . ' ' . $this->request->data['Budget']['title'];
                    $this->request->data['Note']['document_date'] = $tmpDate;
                    $this->request->data['Note']['due_date'] = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +' . $this->request->data['Budget']['due_days'] . ' days'));
                    $this->request->data['Note']['note_status_id'] = '1';
                    switch ($this->request->data['Budget']['share_periodicity_id']):
                        case 1:
                            $tmpDate = $tmpDate;
                            break;
                        case 2:
                            $tmpDate = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +1 year'));
                            break;
                        case 3:
                            $tmpDate = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +6 months'));
                            break;
                        case 4:
                            $tmpDate = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +3 months'));
                            break;
                        case 5:
                            $tmpDate = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +1 month'));
                            break;
                        case 6:
                            $tmpDate = date(Configure::read('Application.dateFormatSimple'), strtotime($tmpDate . ' +1 week'));
                            break;
                        default:
                            break;
                    endswitch;
                    $this->_addNote();
                    if ($note['common_reserve_fund'] > 0) {
                        $this->request->data['Note']['pending_amount'] = $note['common_reserve_fund'];
                        $this->request->data['Note']['amount'] = $note['common_reserve_fund'];

                        $this->request->data['Note']['title'] = __('Common Reserve Fund') . ' ' . $shares . ' ' . __($month) . ' ' . $this->request->data['Budget']['title'];
                        $this->_addNote();
                    }
                    $this->request->data['Note']['amount'] = $note['amount'];
                    $this->request->data['Note']['pending_amount'] = $note['amount'];

                    $shares++;
                endwhile;
            }
            $this->Flash->success(__('The notes has been created'));
            $this->redirect(array('controller' => 'notes', 'action' => 'create', '?' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));
        }

        $this->Note->Fraction->contain(array('Entity'));
        $fractions = $this->Note->Fraction->find('all', array('order' => array('Fraction.fraction' => 'asc'), 'conditions' => array('condo_id' => $this->getPhkRequestVar('condo_id'))));

        $totalMilRate = 0;
        $budgetAmount = 0;
        $numOfShares = 0;
        $numOfFractions = count($fractions);
        foreach ($fractions as $fraction) {
            $totalMilRate += $fraction['Fraction']['permillage'];
        }

        $this->set(compact('fractions'));
    }

    private function _addNote()
    {
        $this->Note->create();
        $this->request->data['Note']['fiscal_year_id'] = $this->getPhkRequestVar('fiscal_year_id');
        if ($this->Note->save($this->request->data)) {
            $this->_setDocument();
        } else {
            $this->Note->deleteAll(array('Note.budget_id' => $this->request->data['Budget']['id']), false);
            $this->Flash->error(__('The notes could not be created. Please, try again.'));
            $this->redirect(array('action' => 'create', '?' => $this->request->query));
        }
    }
    private function _setDocument()
    {
        if (is_array($this->request->data['Note']['document_date'])) {
            $dateTmp = $this->request->data['Note']['document_date']['day'] . '-' . $this->request->data['Note']['document_date']['month'] . '-' . $this->request->data['Note']['document_date']['year'];
            $this->request->data['Note']['document_date'] = $dateTmp;
        };
        //debug($this->request->data['Note']['document_date']);
        $date = new DateTime($this->request->data['Note']['document_date']);
        $dateResult = $date->format('Y');
        $document = $this->Note->id . '-' . $this->request->data['Note']['note_type_id'];
        $this->Note->saveField('document', $document);
        return true;
    }

    public function beforeFilter()
    {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('condo_id') || !$this->getPhkRequestVar('fiscal_year_id')) {
            $this->Flash->error(__('Invalid condo or fiscal year'));
            $this->redirect(array('controller' => 'condos', 'action' => 'index'));
        }
    }

    public function beforeRender()
    {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text') . ' ( ' . $this->phkRequestData['fiscal_year_text'] . ' ) ', 'active' => ''),
        );
        switch ($this->action) {
            case 'create':
                $breadcrumbs[1] = array('link' => '', 'text' => __('Notes Generator'), 'active' => 'active');
                break;
        }
        $headerTitle = __n('Note', 'Notes', 2);
        $this->set(compact('breadcrumbs', 'headerTitle'));
    }
}
