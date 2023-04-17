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
 * @since         pHKondo v 1.6.3
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */

class SecureController extends AppController {

    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Install';

    /**
     * No models required
     *
     * @var array
     * @access public
     */
    public $uses = array();

    /**
     * Helpers
     *
     * @var array
     * @access public
     */
    public $helpers = array('Html', 'Form');

    /**
     * Step 0: welcome
     *
     * A simple welcome message for the installer.
     *
     * @return void
     * @access public
     */
    public function index() {
        $this->render('notFound');
    }

    /**
     * This method should be called on first time run after manual instalation
     *
     * @return void
     * @access public
     */
    public function resetAllPasswords() {
        $secure = $this->Session->read('Secure');
        if (isset($secure['key']) && $secure['key'] == $token) {
            unset($secure['key']);
            $this->Session->delete('Secure');
            // secure app with new salt/seed
            $this->__setNewSaltSeed();
            // update all user passwords with new salt/seed 
            $this->__updatePasswords();
            
        }
        $this->redirect('/');
    }

    private function __setNewSaltSeed() {
        // set new salt and seed value
        $File = new File(APP . 'Config' . DS . 'core_app.php');
        $salt = Security::generateAuthKey();
        $seed = mt_rand() . mt_rand();
        $contents = $File->read();
        $contents = preg_replace('/(?<=Configure::write\(\'Security.salt\', \')([^\' ]+)(?=\'\))/', $salt, $contents);
        $contents = preg_replace('/(?<=Configure::write\(\'Security.cipherSeed\', \')(\d+)(?=\'\))/', $seed, $contents);
        if (!$File->write($contents)) {
            $this->Flash->info(__d('install','Unable to secure your application, your Config %s core_app.php file is not writable. Please check the permissions.', DS));
            $this->log(__d('install','Unable to secure your application, your Config %s core_app.php file is not writable. Please check the permissions.', DS));
            return false;
        }
        Configure::write('Security.salt', $salt);
        Configure::write('Security.cipherSeed', $seed);

        return true;
    }

    /**
     * Update Passwords
     *
     * Updates all users passwords with new salt value
     * Setting new password equals username 
     * @param $user
     * @return $mixed if false, indicates processing failure
     */
    private function __updatePasswords() {

        $this->loadModel('User');
        $users = $this->User->find('all');
        foreach ($users as $key => $user) {
            $users[$key]['User']['password'] = $users[$key]['User']['username'];
        }
        // update all users
        if (!$this->User->saveAll($users)) {
            $this->Flash->error(__d('install','Unable to generate users password.'));
            $this->log(__d('install','Unable to generate users password.'));
            $this->log($User->validationErrors);
            return false;
        }
        return true;
    }

    /**
     * isAuthorized
     *
     * @param  user data array
     * @return boolean
     * @access public
     * @throws 
     */
    public function isAuthorized($user = null) {
        if ($user['role'] != 'store_admin') {
            $this->Flash->info(__d('install', 'Already Secured'));
            $this->redirect('/');
            return false;
        }
        return true;
    }

    /**
     * beforeFilter
     *
     * @return void
     * @access public
     */
    public function beforeFilter() {
        $this->Components->unload('Notify');
        parent::beforeFilter();
        $this->Auth->allow();

//$this->layout = 'install';
    }

}
