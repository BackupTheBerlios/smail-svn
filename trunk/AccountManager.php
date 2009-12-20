<?php

require_once 'Account.php';
require_once 'Manager.php';
require_once 'WEBDIR.php';


class AccountManager extends Manager {

    protected function __default(array $params) {
        if(isset($_SESSION['account']))
            header('Location: '.WEBDIR.'Profil');

        $smarty = SmailSmarty::getInstance();

        $smarty->setTemplate('login.tpl');
        $smarty->assign('Login', WEBDIR.'Login');
        $smarty->assign('newAccount', WEBDIR.'Register');
    }

    protected function create(array $params) {
        $smarty = SmailSmarty::getInstance();
        $smarty->setTemplate('login.tpl');

        if(!(isset($params['name']) && isset($params['password']) && isset($params['confirm']))) {
            $smarty->assign('CREATE_ERRORS', 1);
        }
        elseif($params['password']!=$params['confirm']) {
            $smarty->assign('CREATE_ERRORS', 2);
        }
        else {
            $account = new Account($params['name'], $params['password']);

            if(!$account->exists()) {
                if($account->create()) {
                    $_SESSION['account'] = $account->getName();
                    header('Location: '.WEBDIR.'Profil');
                }
            } else {
                $smarty->setTemplate('login.tpl');
                $smarty->assign('CREATE_ERRORS', 3);
            }
        }
    }

    protected function login(array $params) {
        $this->__default($params);

        $smarty = SmailSmarty::getInstance();

        if(!(isset($params['name']) && isset($params['password']))) {
            $smarty->assign('LOGIN_ERRORS', 1);
        }
        else {
            $account = new Account($params['name'], $params['password']);

            if($account->exists()) {
                $_SESSION['account'] = $account->getName();
                header('Location: '.WEBDIR.'Profil');
            } else {
                $smarty->assign('LOGIN_ERRORS', 1);
            }
        }
    }

    protected function welcome(array $params) {
        $this->access($params);

        $smarty = SmailSmarty::getInstance();

        $smarty->assign('new', 1);
    }

    protected function access(array $params) {
        if(!isset($_SESSION['account']))
            $this->logout($params);

        $smarty = SmailSmarty::getInstance();

        $smarty->setTemplate('profil.tpl');
        $smarty->assign('user', $_SESSION['account']);
    }

    protected function logout(array $params) {
        if(!isset($_SESSION['account']))
            header('Location: '.WEBDIR);

        session_destroy();
        unset($_SESSION);

        $smarty = SmailSmarty::getInstance();

        $smarty->setTemplate('login.tpl');
        $smarty->assign('Login', WEBDIR.'Login');
        $smarty->assign('newAccount', WEBDIR.'Register');
        $smarty->assign('logout', 1);
    }
} ?>