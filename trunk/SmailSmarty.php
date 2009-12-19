<?php

require_once './smarty/Smarty.class.php';

class SmailSmarty extends Smarty {
    private static $INSTANCE = null;
    private $template = '';
    
    private function __construct() {
        $this->template_dir = './tpl/';
        $this->compile_dir = './smarty/templates_c/';
    }
    
    public static function getInstance() {
        if(self::$INSTANCE==null) {
            self::$INSTANCE = new SmailSmarty();
        }
        
        return self::$INSTANCE;
    }
    
    public function setTemplate($tpl) {
        $this->template = $tpl;
    }
    
    public function render() {
        return $this->fetch($this->template);
    }

} ?>