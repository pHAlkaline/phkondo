<?php

/**
 *
 * pHKondo : pHKondo software for condominium property managers (http://phalkaline.net)
 * Copyright (c) pHAlkaline . (http://phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (http://phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @package       app.Controller
 * @since         pHKondo v 1.6.3
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('File', 'Utility');
App::uses('CakeSchema', 'Model');
App::uses('ConnectionManager', 'Model');

class InstallController extends AppController {

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
     * Default configuration
     *
     * @var array
     * @access public
     */
    public $defaultConfig = array(
        'name' => 'default',
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'phkondo',
        'schema' => null,
        'prefix' => null,
        'encoding' => 'utf8',
        'port' => null,
    );

    /*
     * Default email configuration
     * 
     * @var array
     * @access public
     */
    public $defaultEmail = array(
        'sender_email' => 'noreply@yourdomain.com',
        'email' => 'noreply@yourdomain.com',
        'name' => 'reply to',
        'subject' => 'pHKondo Notification',
        'host' => 'localhost',
        'port' => '25',
        'username' => 'username',
        'password' => '',
    );

    /**
     * beforeFilter
     *
     * @return void
     * @access public
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->Auth->deny('reinstall');
        $this->layout = 'clean';
    }

    /**
     * beforeRender callback
     *
     * @param  
     * @return 
     * @access public
     * @throws 
     */
    public function beforeRender() {
        parent::beforeRender();
        $this->set('user_at_string', __d('install', 'Installation: Welcome'));
    }

    /**
     * If installed.txt exists, app is already installed
     *
     * @return void
     */
    protected function __check() {
        if (file_exists(TMP . 'installed.txt')) {
            $this->Flash->info(__d('install', 'Already Installed'));
            $this->redirect('/');
        }

        if (Configure::read('installed_key') != 'xyz') {
            $this->Flash->info(__d('install', 'Already Installed'));
            $this->redirect('/');
        }
    }

    /**
     * Step 0: welcome
     *
     * A simple welcome message for the installer.
     *
     * @return void
     * @access public
     */
    public function index() {
        $this->__check();
        $this->__files();
       
        if (isset($this->request->data['Install']['language']) && $this->request->data['Install']['language'] != '') {
            $this->Cookie->write('Config.language', $this->request->data['Install']['language'], false, "12 months");
            Configure::write('Config.language', $this->request->data['Install']['language']);
        }
        if (isset($this->request->data['Install']['mode']) && $this->request->data['Install']['mode'] != '') {
            $this->Cookie->write('Application.mode', $this->request->data['Install']['mode'], false, "12 months");
            Configure::write('Application.mode', $this->request->data['Install']['mode']);
        }
        $this->set('title_foApplication.isFullPackr_layout', __d('install', 'Installation: Welcome'));
        $this->set('title_for_step', __d('install', 'Installation: Welcome'));

        $packList = array('free' => 'Community');
        if (Configure::read('Application.isFullPack')) {
            $packList = array(
                'free' => 'Community',
                'full' => 'Full Pack',
                'one' => 'Full Pack One',
                'pro' => 'Full Pack Pro',
                'demo' => 'Demonstration'
            );
        }
        $this->set('packList', $packList);
    }

    private function __files() {
        copy(APP . 'Config' . DS . 'core_phapp.php.default', APP . 'Config' . DS . 'core_phapp.php');
        copy(APP . 'Config' . DS . 'bootstrap_phapp.php.default', APP . 'Config' . DS . 'bootstrap_phapp.php');
    }


    /**
     * Step : database
     *
     * Try to connect to the database and give a message if that's not possible so the user can check their
     * credentials or create the missing database
     * Create the database file and insert the submitted details
     *
     * @return void
     * @access public
     */
    public function database() {
        $this->__check();
        $this->set('title_for_layout', __d('install', 'Step 1 : Database connection'));
        $this->set('title_for_step', __d('install', 'Step 1 : Database connection'));

        if (isset($this->request->data['Install']['language']) && $this->request->data['Install']['language'] != '') {
            $this->Cookie->write('Config.language', $this->request->data['Install']['language'], false, "12 months");
            Configure::write('Config.language', $this->request->data['Install']['language']);
        }
        if (isset($this->request->data['Install']['mode']) && $this->request->data['Install']['mode'] != '') {
            $this->Cookie->write('Application.mode', $this->request->data['Install']['mode'], false, "12 months");
            Configure::write('Application.mode', $this->request->data['Install']['mode']);
        }

        if (file_exists(APP . 'Config' . DS . 'database.php')) {
            unlink(APP . 'Config' . DS . 'database.php');
            copy(APP . 'Config' . DS . 'database.php.default', APP . 'Config' . DS . 'database.php');
        }


        if (empty($this->request->data)) {
            return;
        }

        $config = $this->defaultConfig;
        foreach ($this->request->data as $key => $value) {
            if (isset($config[$key])) {
                $config[$key] = $value;
            }
        }
        try {
            ConnectionManager::create('default', $config);
            $db = ConnectionManager::getDataSource('default');
        } catch (MissingConnectionException $e) {

            $this->Flash->info(__d('install', 'Could not connect to database: %s', $e->getMessage()));
            return;
        }
        if (!$db->isConnected()) {
            $this->Flash->error(__d('install', 'Could not connect to database.'));
            return;
        }


        $file = new File(APP . 'Config' . DS . 'database.php', true);
        $content = $file->read();

        foreach ($config as $configKey => $configValue) {
            $content = str_replace('{default_' . $configKey . '}', $configValue, $content);
        }

        if (!$file->write($content)) {
            $this->Flash->error(__d('install', 'Could not write database.php file.'));
            return;
        }
        return $this->redirect(array('action' => 'data'));
    }

    /**
     * Step : Run the initial sql scripts to create the db and seed it with data
     *
     * @return void
     * @access public
     */
    public function data() {
        $this->__check();
        $this->set('title_for_layout', __d('install', 'Step 2 : Build database , load table values'));
        $this->set('title_for_step', __d('install', 'Step 2 : Build database , load table values'));
        if (empty($this->request->data)) {
            return;
        }

        $db = ConnectionManager::getDataSource('default');
        $brokenSequence = $db instanceof Postgres;
        if (!$db->isConnected()) {
            $this->Flash->error(__d('install', 'Could not connect to database.'));
        } else {

            //phkondo structure
            $structure_file = APP . 'Config' . DS . 'Schema' . DS . 'phkondo_' . Configure::read('Config.language') . '.sql';
            if (!file_exists($structure_file)) {
                $structure_file = APP . 'Config' . DS . 'Schema' . DS . 'phkondo.sql';
            }
            try {
                $this->__executeSQLScript($db, $structure_file);
            } catch (MissingConnectionException $e) {

                $this->Flash->error(__d('install', 'Could not load database: %s', $e->getMessage()));
                return;
            }

            // attachement plugin
            $attachment_file = APP . 'Plugin' . DS . 'Attachments' . DS . 'Config' . DS . 'Schema' . DS . 'attachment.sql';
            if (file_exists($attachment_file)) {
                try {
                    $this->__executeSQLScript($db, $attachment_file);
                } catch (MissingConnectionException $e) {

                    $this->Flash->error(__d('install', 'Could not load database: %s', $e->getMessage()));
                    return;
                }
            }

            // feedback plugin
            $feedback_file = APP . 'Plugin' . DS . 'Feedback' . DS . 'Config' . DS . 'Schema' . DS . 'feedback.sql';
            if (file_exists($feedback_file)) {

                try {
                    $this->__executeSQLScript($db, $feedback_file);
                } catch (MissingConnectionException $e) {

                    $this->Flash->error(__d('install', 'Could not load database: %s', $e->getMessage()));
                    return;
                }
            }

            // drafts plugin
            $drafts_file = APP . 'Plugin' . DS . 'Drafts' . DS . 'Config' . DS . 'Schema' . DS . 'drafts.sql';
            if (file_exists($drafts_file)) {
                try {
                    $this->__executeSQLScript($db, $drafts_file);
                } catch (MissingConnectionException $e) {

                    $this->Flash->error(__d('install', 'Could not load database: %s', $e->getMessage()));
                    return;
                }
            }

            if ($this->request->data['demo_data'] == '1') {

                // phkondo demo data
                $demo_data_file = APP . 'Config' . DS . 'Schema' . DS . 'phkondodata_' . Configure::read('Config.language') . '.sql';
                if (!file_exists($demo_data_file)) {
                    $demo_data_file = APP . 'Config' . DS . 'Schema' . DS . 'phkondodata.sql';
                }

                try {
                    $this->__executeSQLScript($db, $demo_data_file);
                } catch (MissingConnectionException $e) {

                    $this->Flash->error(__d('install', 'Could not load database: %s', $e->getMessage()));
                    return;
                }

                // drafts demo data

                $drafts_data_file = APP . 'Plugin' . DS . 'Drafts' . DS . 'Config' . DS . 'Schema' . DS . 'draftsdata_' . Configure::read('Config.language') . '.sql';
                if (file_exists($drafts_data_file)) {

                    try {
                        $this->__executeSQLScript($db, $drafts_data_file, false);
                    } catch (MissingConnectionException $e) {

                        $this->Flash->error(__d('install', 'Could not load database: %s', $e->getMessage()));
                        return;
                    }
                }
            }
            if ($this->request->data['demo_condo'] == '1') {

                // phkondo demo data
                $demo_data_file = APP . 'Config' . DS . 'Schema' . DS . 'phkondo-democondo_' . Configure::read('Config.language') . '.sql';
                if (!file_exists($demo_data_file)) {
                    $demo_data_file = APP . 'Config' . DS . 'Schema' . DS . 'phkondo-democondo.sql';
                }

                try {
                    $this->__executeSQLScript($db, $demo_data_file);
                } catch (MissingConnectionException $e) {
                    $this->Flash->error(__d('install', 'Could not load database: %s', $e->getMessage()));
                    return;
                }
            }
        }

        $this->redirect(array('action' => 'email'));
    }

    private function __executeSQLScript($db, $fileName, $separator = ';') {

        $file_contents = file_get_contents($fileName);
        $statements = $separator ? explode($separator, $file_contents) : $file_contents;
        if (is_array($statements)) {
            foreach ($statements as $statement) {
                if (trim($statement) != '') {

                    $db->query($statement);
                }
            }
        } else {

            $db->query($statements);
        }
    }

    private function __setNewSaltSeed() {
        // set new salt and seed value
        $File = new File(APP . 'Config' . DS . 'core_phapp.php');
        $salt = Security::generateAuthKey();
        $seed = mt_rand() . mt_rand();
        $contents = $File->read();
        $contents = preg_replace('/(?<=Configure::write\(\'Security.salt\', \')([^\' ]+)(?=\'\))/', $salt, $contents);
        $contents = preg_replace('/(?<=Configure::write\(\'Security.cipherSeed\', \')(\d+)(?=\'\))/', $seed, $contents);
        if (!$File->write($contents)) {
            $this->Flash->error(__d('install', 'Unable to secure your application, your Config %s core_phapp.php file is not writable. Please check the permissions.', DS));
            $this->log('Unable to secure your application, your Config %s core_phapp.php file is not writable. Please check the permissions.', DS);
            return false;
        }
        Configure::write('Security.salt', $salt);
        Configure::write('Security.cipherSeed', $seed);

        return true;
    }

    /**
     * Step : email
     *
     * Create the email file and insert the submitted details
     *
     * @return void
     * @access public
     */
    public function email() {
        $this->__check();
        $this->set('title_for_layout', __d('install', 'Step 3 : Email notification'));
        $this->set('title_for_step', __d('install', 'Step 3 : Email notification'));

        if (empty($this->request->data)) {
            if (file_exists(APP . 'Config' . DS . 'email_notifications.php')) {
                unlink(APP . 'Config' . DS . 'email_notifications.php');
                copy(APP . 'Config' . DS . 'email_notifications.php.default', APP . 'Config' . DS . 'email_notifications.php');
            }
            return;
        }

        if (file_exists(APP . 'Config' . DS . 'email.php')) {
            unlink(APP . 'Config' . DS . 'email.php');
            copy(APP . 'Config' . DS . 'email.php.default', APP . 'Config' . DS . 'email.php');
        }


        $config = $this->defaultEmail;
        foreach ($this->request->data as $key => $value) {
            if (isset($config[$key])) {
                $config[$key] = $value;
            }
        }
        $file = new File(APP . 'Config' . DS . 'email.php', true);
        $content = $file->read();

        foreach ($config as $configKey => $configValue) {
            $content = str_replace('{default_' . $configKey . '}', $configValue, $content);
        }

        if (!$file->write($content)) {
            $this->Flash->error(__d('install', 'Could not write email.php file.'));
            return;
        }

        $emailNotifications = Configure::read('EmailNotifications.eng');
        if (Configure::check('EmailNotifications.' . Configure::read('Config.language'))) {
            $emailNotifications = Configure::read('EmailNotifications.' . Configure::read('Config.language'));
        }
        Configure::write('EmailNotifications', $emailNotifications);

        Configure::write('EmailNotifications.active', true);
        if (!Configure::dump('email_notifications.php', 'default', array('EmailNotifications'))) {
            $this->Flash->error(__d('email', 'Could not save notification settings.'));
            return;
        }

        $this->redirect(array('action' => 'adminuser'));
    }

    /**
     * Step : secure app and set new password for administrative user
     */
    public function adminuser() {
        $this->__check();
        $this->set('title_for_layout', __d('install', 'Step 4 : Admin Account'));
        $this->set('title_for_step', __d('install', 'Step 4 : Admin Account'));
        if (empty($this->request->data)) {
            return;
        }

        if ($this->request->is('post')) {
            // secure app
            if (!$this->__secure()) {
                $this->Flash->error(__d('install', 'Unable to create administrative user.'));
                $this->log(__d('install', 'Unable to create administrative user.'));
                return;
            }
            // add admin password
            $this->loadModel('User');
            $this->User->read(null, 1);
            $this->User->set($this->request->data);
            if ($this->User->save()) {
                $this->Flash->info(__d('install', 'Saved with success.'));
                $key = uniqid();
                $this->Cookie->write('Install.key', $key, false, 3600);
                $this->redirect(array('action' => 'finish', $key));
            } else {
                $this->Flash->error(__d('install', 'Unable to create administrative user.'));
                $this->log(__d('install', 'Unable to create administrative user.'));
                $this->log($this->User->validationErrors);
            }
        }
    }

    /**
     * Step 4: finish
     *
     * Copy instaled.txt file into place and create user obtained in step 3
     *
     * @return void
     * @access public
     */
    public function finish($key = null) {
        $this->__check();
        $this->set('title_for_layout', __d('install', 'Installation completed successfully'));
        $this->set('title_for_step', __d('install', 'Installation completed successfully'));
        $install = $this->Cookie->read('Install');
        if (isset($install['key']) && $install['key'] == $key) {
            /// alter configuration
            $File = new File(APP . 'Config' . DS . 'core_phapp.php');
            $contents = $File->read();
            $contents = preg_replace('/(?<=Configure::write\(\'installed_key\', \')([^\' ]+)(?=\'\))/', $key, $contents);
            if (!$File->write($contents)) {
                $this->Flash->error(__d('install', 'Unable to secure your application, your Config %s core_phapp.php file is not writable. Please check the permissions.', DS));
                $this->log('Unable to secure your application, your Config %s core_phapp.php file is not writable. Please check the permissions.', DS);
                $this->redirect('/');
            }

            $File = new File(APP . 'Config' . DS . 'bootstrap_phapp.php');
            $contents = $File->read();
            $application_language = Configure::read('Config.language');
            $contents = preg_replace('/(?<=Configure::write\(\'Language.default\', \')([^\' ]+)(?=\'\))/', $application_language, $contents);

            $application_mode = Configure::read('Application.mode');
            if ($this->Cookie->check('Application.mode')) {
                $application_mode = $this->Cookie->read('Application.mode');
            }
            $contents = preg_replace('/(?<=Configure::write\(\'Application.mode\', \')([^\' ]+)(?=\'\))/', $application_mode, $contents);
            /*if ($application_mode != 'free') {
                $search = array(
                    "//CakePlugin::load('PrintReceipt', array('bootstrap' => true))",
                    "//CakePlugin::load('Reports', array('bootstrap' => true))",
                    "//CakePlugin::load('Drafts', array('bootstrap' => true))",
                    "//CakePlugin::load('Attachments', array('bootstrap' => true))"
                );
                $replace = array(
                    "CakePlugin::load('PrintReceipt', array('bootstrap' => true))",
                    "CakePlugin::load('Reports', array('bootstrap' => true))",
                    "CakePlugin::load('Drafts', array('bootstrap' => true))",
                    "CakePlugin::load('Attachments', array('bootstrap' => true))"
                );
                $contents = str_replace($search, $replace, $contents);
            }*/

            if (!$File->write($contents)) {
                $this->Flash->error(__d('install', 'Unable to config your application, your Config %s bootstrap_phapp.php file is not writable. Please check the permissions.', DS));
                $this->log('Unable to config your application, your Config %s bootstrap_phapp.php file is not writable. Please check the permissions.', DS);
                $this->redirect('/');
            }

            // Create a new file with 0644 permissions
            $file = new File(TMP . 'installed.txt', true, 0644);
            if ($file) {
                $file->append(__d('install', 'Installation completed successfully'));
                $file->append(' - ' . $key);
                $file->close();
                $this->Flash->info(__d('install', 'Installation completed successfully'));
            } else {
                $this->set('title_for_layout', __d('install', 'Installation not completed successfully'));
                $this->set('title_for_step', __d('install', 'Installation not completed successfully'));
                $this->Flash->error(__d('install', 'Something went wrong during installation. Please check your server logs.'));
            }
            $this->Cookie->delete('Install');
            $this->Cookie->delete('Config.language');
            $this->Cookie->delete('Application.mode');
        } else {
//$this->redirect('/');
        }
    }

    /**
     * Step * : secure
     * This method should be called on first time run after manual instalation
     * Copy instaled.txt file into place , secure app, and set default password to all users
     * Default password equals username
     *
     * @return void
     * @access public
     */
    private function __secure() {

        // secure app
        if (!$this->__setNewSaltSeed()) {
            return false;
        }
        // update all user passwords with new salt/seed 
        if (!$this->__updatePasswords()) {
            return false;
        }
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
            $newPass=$users[$key]['User']['username'];
            if ($users[$key]['User']['username']=='demo'){
                $newPass='demo1234';
            }
            $users[$key]['User']['password'] = str_pad($newPass, 8, "0", STR_PAD_RIGHT) . '0';
        }
        // update all users
        if (!$this->User->saveAll($users)) {

            $this->Flash->error(__d('install', 'Unable to generate users password.'));
            $this->log(__d('install', 'install', 'Unable to generate users password.'));
            //$this->log($users->validationErrors);
            return false;
        }
        return true;
    }

    public function reinstall() {
        unlink(APP . 'Config' . DS . 'core_phapp.php');
        unlink(TMP . 'installed.txt');
        $this->redirect(array('action' => 'index'));
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
        if ($user['role'] != 'admin') {
            $this->Flash->info(__d('install', 'Already Installed'));
            return false;
        }
        return parent::isAuthorized($user);
    }

}
