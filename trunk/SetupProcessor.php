<?php

require_once 'MySQLiFactory.php';
require_once 'Processor.php';
require_once 'Template.php';
require_once 'SmailSmarty.php';

class SetupProcessor implements Processor {

	public function processParams($simpleParams, $heavyParams) {
		$data = $this->processSetupData($heavyParams);
		if ($data == null) {
			return $this->askForData();
		}
		$data->toFile(MySQLiFactory::$CONFIG_FILE);
		header('Location: ./');
	}

	private function askForData() {
        $tmpl = new Template();
		if (is_writable('.')) {
			$tmpl->setTemplate('setup.tpl');
		} else {
            $tmpl->setTemplate('setup_MakeWritable.tpl');
		}
		return $tmpl->render();
	}

	private function processSetupData($params) {
		if (!isset($params['host'])) return null;
		$host = stripslashes($params['host']);
        if (!isset($params['user'])) return null;
        $user = stripslashes($params['user']);
        if (!isset($params['passwd'])) return null;
        $passwd = stripslashes($params['passwd']);
        if (!isset($params['dbname'])) return null;
        $dbname = stripslashes($params['dbname']);
        return new SetupData($host, $user, $passwd, $dbname);
	}

}

class SetupData {

	private $filedata;

	function __construct($host, $user, $passwd, $dbname) {
        $this->filedata = '<?php $host = \'' . $host
        . '\'; $user = \'' . $user
        . '\'; $passwd = \'' . $passwd
        . '\'; $dbname = \''.$dbname.'\'; ?>' . "\n";
	}

	function toFile($filename) {
		$fp = fopen($filename, 'w');
		fwrite($fp, $this->filedata, strlen($this->filedata));
		fclose($fp);
		chmod($filename, 0400);
	}

}

?>