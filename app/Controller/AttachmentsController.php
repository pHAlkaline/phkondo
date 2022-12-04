<?php

/**
 *
 * pHKondo : pHKondo software for condominium property managers (https://www.phalkaline.net)
 * Copyright (c) pHAlkaline . (https://www.phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (https://www.phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @package       app.Controller
 * @since         pHKondo v 1.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');

/**
 * Attachments Controller
 *
 * @property PaginatorComponent $Paginator
 */
class AttachmentsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('RequestHandler');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text') . ' ( ' . $this->phkRequestData['fiscal_year_text'] . ' ) ', 'active' => ''),
            array('link' => Router::url(array('controller' => 'attachments', 'action' => 'index', '?' => $this->request->query), true), 'text' => __n('Attachment', 'Attachments', 2), 'active' => 'active')
        );


        $this->set(compact('breadcrumbs'));
        $this->render('notfound');
    }

    /**
     * fraction_attachments method
     *
     * @return void
     */
    public function fraction_attachments() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text') . ' ( ' . $this->phkRequestData['fiscal_year_text'] . ' ) ', 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Fraction', 'Fractions', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'fractions', 'action' => 'view', $this->getPhkRequestVar('fraction_id'))), 'text' => $this->getPhkRequestVar('fraction_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'attachments', 'action' => 'fraction_attachments', '?' => $this->request->query), true), 'text' => __n('Attachment', 'Attachments', 2), 'active' => 'active')
        );


        $this->set(compact('breadcrumbs'));
        $this->render('notfound');
    }

    /**
     * ensurance_attachments method
     *
     * @return void
     */
    public function insurance_attachments() {
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'condos', 'action' => 'view', $this->getPhkRequestVar('condo_id'))), 'text' => $this->getPhkRequestVar('condo_text') . ' ( ' . $this->phkRequestData['fiscal_year_text'] . ' ) ', 'active' => ''),
            array('link' => Router::url(array('controller' => 'insurances', 'action' => 'index', '?' => $this->request->query)), 'text' => __n('Insurance', 'Insurances', 2), 'active' => ''),
            array('link' => Router::url(array('controller' => 'insurances', 'action' => 'view', $this->getPhkRequestVar('insurance_id'))), 'text' => $this->getPhkRequestVar('insurance_text'), 'active' => ''),
            array('link' => Router::url(array('controller' => 'attachments', 'action' => 'insurance_attachments', '?' => $this->request->query), true), 'text' => __n('Attachment', 'Attachments', 2), 'active' => 'active')
        );


        $this->set(compact('breadcrumbs'));
        $this->render('notfound');
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->getPhkRequestVar('condo_id')) {
            $this->Flash->error(__('Invalid condo'));
            $this->redirect(array('controller' => 'condos', 'action' => 'index'));
        }
    }

    public function beforeRender() {
        parent::beforeRender();
        $headerTitle = __n('Attachment', 'Attachments', 2);
        $this->set(compact('headerTitle'));
    }

}
