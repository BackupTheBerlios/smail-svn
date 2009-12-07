<?php

require_once 'Account.php';
require_once 'Manager.php';

class AccountManager extends Manager {
    /*
     * TODO: Kriegen wir die Texte noch ins Template rein?
     */
    const ACCOUNT_EXISTS =
        'Der Benutzername ist bereits vergeben.';

    const ACCOUNT_NOT_EXIST =
        'Benutzername und/oder Password sind falsch.';

    private function create(array $param) {
        if(!(isset($param['account']) && isset($param['password']))) {
            $this->setError(self::NO_ACTION);
        }
        else {
            $account = new Account($param['account'], $param['password']);

            if(!$account->exist()) {
                $account->create();
                //$_SESSION['account'] = $account->getName();

                //header('Location: '.DOMAIN.'Login/');
            } else {
                $this->setError(self::ACCOUNT_EXISTS);
            }
        }

        $this->render();
    }

    private function login(array $param) {
        if(!(isset($param['account']) && isset($param['password']))) {
            $this->setError(self::NO_ACTION);
        }
        else {
            $account = new Account($param['account'], $param['password']);

            if($account->exist()) {
                $account->create($param['password']);
                //$_SESSION['account'] = $account->getName();

                //header('Location: '.DOMAIN.'Account/');
            } else {
                $this->setError(self::ACCOUNT_NOT_EXISTS);
            }
        }

        $this->render();
    }

    private function logout(array $param) {
        //session_destroy();
        //unset($_SESSION);
    }
} ?>