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
 * @package       app.Controller
 * @since         pHKondo v 1.4.5
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');

/**
 * Comments Controller
 *
 * @property Condo $Condo
 * @property PaginatorComponent $Paginator
 */
class CommentsController extends AppController {

    public $components = array('Feedback.Comments' => array('on' => array('view')));
    
    /**
     * add method
     *
     * @return void
     */
    public function add($foreign_model = null, $foreign_id = null) {
        
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        
        if (empty($foreign_model) || empty($foreign_id) || !$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        App::uses($foreign_model, 'Model');
        $Model = ClassRegistry::init($foreign_model);

        if (!($Model instanceof Model)) {
            throw new MethodNotAllowedException();
        }

        if ($Model->hasAny(array($Model->primaryKey => $foreign_id)) == false) {
            throw new MethodNotAllowedException();
        }

        if (!isset($this->request->data['Comment']['foreign_model']) ||
                !isset($this->request->data['Comment']['foreign_id']) ||
                $this->request->data['Comment']['foreign_model'] != $foreign_model ||
                $this->request->data['Comment']['foreign_id'] != $foreign_id) {
            throw new MethodNotAllowedException();
        }

        $user_id = null;

        if (isset($this->Auth)) {
            $user_id = $this->Auth->user('id');
        }

        $this->request->data['Comment']['foreign_model'] = $Model->name;
        $this->request->data['Comment']['foreign_id'] = $foreign_id;
        $this->request->data['Comment']['user_id'] = $user_id;
        $this->request->data['Comment']['author_ip'] = $this->request->clientIp();

        $this->Comment->create();

        if (!$this->Comment->save($this->request->data)) {
            $this->set('validation_errors', $this->Comment->validationErrors);
            $this->redirect($this->request->referer() . '#comment-' . $this->Comment->id);
        }

        if ($this->request->data['Comment']['remember_info']) {
            $this->Comments->saveInfo();
        } else {
            $this->Comments->forgetInfo();
        }

        $this->redirect($this->request->referer() . '#CommentsPanel');
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $redirect = $this->request->referer(). '#CommentsPanel';
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(__d('feedback', 'Invalid request.'));
        }
        if ($this->Comment->delete()) {
            $this->Flash->success(__d('feedback', 'Record deleted.'));
            $this->redirect($redirect);
        }
        $this->Flash->error(__d('feedback', 'Failed, record was not deleted.'));

        $this->redirect($redirect);
    }

}
