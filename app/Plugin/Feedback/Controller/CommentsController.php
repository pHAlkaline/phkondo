<?php

/**
  CakePHP Feedback Plugin

  Copyright (C) 2012-3827 dr. Hannibal Lecter / lecterror
  <http://lecterror.com/>

  Multi-licensed under:
  MPL <http://www.mozilla.org/MPL/MPL-1.1.html>
  LGPL <http://www.gnu.org/licenses/lgpl.html>
  GPL <http://www.gnu.org/licenses/gpl.html>
 */
App::uses('FeedbackAppController', 'Feedback.Controller');

/**
 * Comments Controller
 *
 * @property CommentsComponent $Comments
 * @property AuthComponent $Auth
 */
class CommentsController extends FeedbackAppController {

    public $components = array('Feedback.Comments');

    public function add($foreign_model = null, $foreign_id = null) {
        if (empty($foreign_model) ||
                empty($foreign_id) ||
                !$this->request->is('post')
        ) {
            return $this->redirect('/');
        }

        App::uses($foreign_model, 'Model');
        $Model = ClassRegistry::init($foreign_model);

        if (!($Model instanceof Model)) {
            return $this->redirect('/');
        }

        if ($Model->hasAny(array($Model->primaryKey => $foreign_id)) == false) {
            return $this->redirect('/');
        }

        if (!isset($this->request->data['Comment']['foreign_model']) ||
                !isset($this->request->data['Comment']['foreign_id']) ||
                $this->request->data['Comment']['foreign_model'] != $foreign_model ||
                $this->request->data['Comment']['foreign_id'] != $foreign_id) {
            return $this->redirect('/');
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
            return;
        }

        if ($this->request->data['Comment']['remember_info']) {
            $this->Comments->saveInfo();
        } else {
            $this->Comments->forgetInfo();
        }

        $this->redirect($this->request->referer() . '#comment-' . $this->Comment->id);
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
        $redirect = $this->request->referer() . '#comment';
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(__('Invalid request.'));
        }
        if ($this->Comment->delete()) {
            $this->Flash->success(__('Success, record deleted.'));
            $this->redirect($redirect );
        }
        $this->Flash->error(__('Failed, record was not deleted.'));

        $this->redirect($redirect);
    }

}
