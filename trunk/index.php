<?php

/*
 * Main script.
 * Processes the input and deligates all requests.
 */

require_once 'magic_quotes.php';
require_once 'MySQLiFactory.php';

class Smail {

	public static function main() {
		self::checkMySqlConfig();
	}

	private static function checkMySqlConfig() {
		if (!MySQLiFactory::configIsReadable()) {
			require_once 'SetupProcessor.php';
			$processor = new SetupProcessor();
			$tmpl = new Template();
			$tmpl->setTemplate('html.tpl');
			$content = $processor->processParams($_GET, $_POST);
			$tmpl->assign('content', $content);
			echo $tmpl->render();
			exit;
		}
	}

}

Smail::main();

/* --------------------------- procedural style ----------------------------- */

require_once 'SmailSmarty.php';
require_once 'AccountManager.php';

session_start();

$params = array();

foreach($_GET as $key => $value) {
    $params[$key] = $value;
}

foreach($_POST as $key => $value) {
    $params[$key] = $value;
}

switch($params['url']) {
    case 'Login':
        new AccountManager('login', $params);
        break;
    case 'Logout':
        new AccountManager('logout', $params);
        break;
    case 'Profil':
        new AccountManager('access', $params);
        break;
    case 'Register':
        new AccountManager('create', $params);
        break;
    case 'Welcome':
        new AccountManager('welcome', $params);
        break;
    default:
        new AccountManager('', $params);
}



$smarty = SmailSmarty::getInstance();
echo $smarty->render();
?>