<?php

App::uses('File', 'Utility');
App::uses('CakeSchema', 'Model');
App::uses('ConnectionManager', 'Model');

class ResetPasswordsShell extends AppShell {

    public $uses = array('User');

    public function main() {
        $this->__updatePasswords();
        return;
    }


    private function __updatePasswords() {
        
        $users = $this->User->find('all');
        foreach ($users as $key => $user) {
            $users[$key]['User']['password'] = str_pad($users[$key]['User']['username'], 8, "0", STR_PAD_RIGHT);
            $this->out($users[$key]['User']['username'].':'.$users[$key]['User']['password']);
        }
        // update all users
        if (!$this->User->saveAll($users)) {

            $this->out(__d('install', 'Unable to generate users password.'));
            $this->out(print_r($users));
            $this->log(__d('install', 'Unable to generate users password.'));
            $this->log(print_r($users));

            //$this->log($users->validationErrors);
            return false;
        }
        return true;
    }

}
