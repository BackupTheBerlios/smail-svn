<?php

//require_once 'Smarty.php';

abstract class Manager {

    protected $error = array();
    /*
     * TODO:
     * Bitte UTF-8 nutzen!
     */
    const NO_ACTION =
        'Aktion konnte nicht ausgef�hrt werden.';

    public function __construct($action, array $params) {
        if(method_exists($this, $action)) {
            $this->$action($param);
        }
        else {
            $this->__default($params);
        }
    }

    public function error() {
        if(count($this->error)>0) {
            return $this->error;
        }

        return false;
    }

    protected function render($tpl) {
        //$smarty = new Smarty();

        // Liste aller verf�gbaren URLs ins Template laden

        //$smarty->display($tpl);
    }

    public function fire() {
    }

    protected function setError($error) {
        $this->error[] = $error;
    }
} ?>