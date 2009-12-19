<?php

/*
 * Main script.
 * Processes the input and deligates all requests.
 */

include_once 'magic_quotes.php';

require_once 'MySQLiFactory.php';

/* Check MySQL configuration */
if (!MySQLiFactory::configIsReadable()) {
	require_once 'Setup.php';
	$setup = new Setup();
	if (isset($_POST['host'])
	 && isset($_POST['user'])
	 && isset($_POST['passwd']) 
	 && isset($_POST['dbname'])) {
	 	$setup->save($_POST['host'], $_POST['user'], $_POST['passwd'], $_POST['dbname']);
	 }
	 echo $setup->output();
	 //exit;
}

if (sizeof($_GET) == 0) {
	readfile('start.html');
	exit;
}

if (isset($_GET['action'])) {
	echo $_GET['action'];
	exit;
}

if (isset($_GET['group'])) {
	echo 'Group: ' . $_GET['group'] . '<br />';
	if (isset($_GET['action'])) {
		echo 'Action: ' . $_GET['action'];
	}
	if (isset($_GET['message'])) {
		echo 'Message: ' . $_GET['message'];
	}
	exit;
}
?>