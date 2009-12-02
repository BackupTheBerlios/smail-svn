<?php

/*
 * Main script.
 * Processes the input and deligates all requests.
 */

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