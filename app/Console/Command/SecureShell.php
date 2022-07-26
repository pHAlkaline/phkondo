<?php

App::uses('File', 'Utility');
App::uses('CakeSchema', 'Model');
App::uses('ConnectionManager', 'Model');

class SecureShell extends AppShell {

    public $uses = array('User');

    public function main() {
        $this->__secure();
        return;
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
            $this->out(__d('install', 'Unable to generate users password.'));
            return;
        }
        return;
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
            $this->out(__d('install', 'Unable to secure your application, your Config %s core_phapp.php file is not writable. Please check the permissions.', DS));
            $this->log(__d('install', 'Unable to secure your application, your Config %s core_phapp.php file is not writable. Please check the permissions.', DS));
            return false;

        }

        Configure::write('Security.salt', $salt);
        Configure::write('Security.cipherSeed', $seed);

        return true;
    }


}
