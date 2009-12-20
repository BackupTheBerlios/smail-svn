<?php

class Template {

	private $smarty;
	private $tmplName;

	public function __construct() {
		$s = new Smarty();
		$s->template_dir = './tpl/';
		$s->compile_dir = './smarty/templates_c/';
		$this->smarty = $s;
	}

    public function setTemplate($tpl) {
        $this->tmplName = $tpl;
    }

    public function assign($key, $value) {
    	$this->smarty->assign($key, $value);
    }

    public function render() {
        return $this->smarty->fetch($this->tmplName);
    }

}
?>