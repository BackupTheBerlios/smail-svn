<?php

require_once 'SmailSmarty.php';

class Setup {
	
	private $smarty;
	
	public function __construct() {
		$smarty = SmailSmarty::getInstance();
		$smarty->setTemplate('setup.tpl');
		$this->smarty = $smarty;
	}
	
	public function save($host, $user, $passwd, $dbname) {
			$fp = fopen('mysql.php','w');
			$filedata = '<?php $host = \'' . $host
			. '\'; $user = \'' . $user
			. '\'; $passwd = \'' . $passwd
			. '\'; $dbname = \''.$dbname.'\'; ?>' . "\n";
			fwrite($fp, $filedata, strlen($filedata));
			fclose($fp);
			chmod('mysql.php',0400);
	}

	public function output() {
		return $this->smarty->render();
	}
}

?>