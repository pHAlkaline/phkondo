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
            $users[$key]['User']['password'] = str_pad($users[$key]['User']['username'], 8, "0", STR_PAD_RIGHT).'0';
            $this->out($users[$key]['User']['username'] . ':' . $users[$key]['User']['password']);
            $user=$users[$key];
            // update user
            if (!$this->User->save($user)) {

                $this->out(__d('install', 'Unable to generate users password.'));
                $this->out(print_r($user));
                $this->out($this->User->validationErrors);
                $this->log(__d('install', 'Unable to generate users password.'));
                $this->log(print_r($user));
                $this->log($this->User->validationErrors);
            }
        }


        return true;
    }

}
