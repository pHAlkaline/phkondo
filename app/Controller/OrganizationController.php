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
 * @since         pHKondo v 1.7.3
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('AppController', 'Controller');

/**
 * Organization Controller
 *
 * @property Entity $Entity
 * @property PaginatorComponent $Paginator
 */
class OrganizationController extends AppController {

    public $useModel = false;

    /**
     * Components
     *
     * @var array
     */
    public $components = array('RequestHandler');

    public function config() {
        $this->set('title_for_layout', __('Organization'));
        $this->set('title_for_step', __('Organization'));
        if (empty($this->request->data)) {
            return;
        }

        if ($this->request->is('post')) {
            //Check if image was sent
            if (!$this->request->data['logo']['size']==0) {
                $file = $this->request->data['logo'];
                $validImage = true;
                //if extension is valid
                list($width, $height) = getimagesize($file['tmp_name']);
                if ($width > "380" || $height > "65") {
                    $validImage = false;
                }

                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //processing file extension

                if (!in_array($ext, $arr_ext)) {
                    $validImage = false;
                }

                if ($validImage) {
                    // delete old file
                    if (Configure::read('Organization.logo')) {
                        unlink(WWW_ROOT . 'img' . DS . 'logos' . DS . Configure::read('Organization.logo'));
                    }
                    //do the actual uploading of the file. First arg is the tmp name, second arg is
                    //where we are putting it
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img' . DS . 'logos' . DS . $file['name']);
                    //saving file on database
                    $this->request->data['logo'] = $file['name'];
                } else {
                    $this->request->data['logo'] = '';
                }
            } else {
                unset($this->request->data['logo']);
            }
            foreach ($this->request->data as $key => $value) {
                $key = substr(h($key), 0, 30);
                $value = substr(h($value), 0, 100);
                if (Configure::check('Organization.' . $key)) {
                    Configure::write('Organization.' . $key, $value);
                }
            }
            if (!Configure::dump('organization.php', 'default', array('Organization'))) {
                $this->Flash->error(__('Could not be saved. Please, try again.'));
                return;
            }
            $this->Flash->success(__('Saved with success.'));
        }
        $this->redirect(array('action' => 'config'));
    }

    public function beforeRender() {
        parent::beforeRender();
        $breadcrumbs = array(
            array('link' => Router::url(array('controller' => 'organization', 'action' => 'config')), 'text' => __('Organization'), 'active' => 'active'));

        $headerTitle = __('Organization');
        $organization = Configure::read('Organization');
        $this->set(compact('breadcrumbs', 'headerTitle', 'organization'));
    }

    public function isAuthorized($user) {

        if (isset($user['role'])) {
            switch ($user['role']) {
                case 'admin':
                    return true;
                    break;
                case 'store_admin':
                    return false;
                    break;
                default:
                    return false;
                    break;
            }
        }


        return parent::isAuthorized($user);
    }

}
