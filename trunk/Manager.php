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

    public function __construct($action, array $param) {
        if(method_exists($this, $action)) {
            $this->$action($param);
        }
        else {
            $this->setError(self::NO_ACTION);
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

    protected function setError($error) {
        $this->error[] = $error;
    }
} ?>