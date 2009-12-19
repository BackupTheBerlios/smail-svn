<?php

/**
 * Provides access to one instance of mysqli.
 * @author maikel
 *
 */
class MySQLiFactory {
	
	public static $CONFIG_FILE = 'mysql.php';
	
	private static $INSTANCE = null;
	
	public static function configIsReadable() {
		if (!is_file(self::$CONFIG_FILE)) {
			return false;
		}
		return is_readable(self::$CONFIG_FILE);
	}

	/**
	 * Returns the one and only instance or dies.
	 * @return mysqli instance
	 */
	public static function getInstance() {
		if ($instance == null) {
			self::createInstance();
		}
		return self::$INSTANCE;
	}
	
	private static function createInstance() {
		if (!self::configIsReadable()) {
			die('MySQL configuration file is not readable.' . "\n");
		}
		include self::$CONFIG_FILE;
		try {
			self::$INSTANCE = new mysqli($host, $user, $passwd);
		} catch (Exception $ex) {
			die('Sorry, could not connect to database.');
		}
		if (!self::$INSTANCE->select_db($dbname)) {
			self::createDatabase($dbname);
		}
	}
	
	private static function createDatabase($dbname) {
		echo 'hallo';
		$db = self::$INSTANCE;
		$db->query('create database `' . $dbname . '`;')
		 or die('Could not create database.');
		$db->select_db($dbname);
		$query 
		= 'CREATE TABLE `account` ('
		. '  `id` varchar(25) NOT NULL default "",'
		. '  `password` varchar(40) default NULL,'
		. '  PRIMARY KEY  (`id`)'
		. ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		$db->query($query);
		$query
		= 'CREATE TABLE `group` ('
		. '  `id` varchar(25) NOT NULL default "",'
		. '  `readInvs` tinyint(3) unsigned NOT NULL default "0",'
		. '  `writeInvs` tinyint(3) unsigned NOT NULL default "0",'
		. '  `description` varchar(255) default NULL,'
		. '  PRIMARY KEY  (`id`)'
		. ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		$db->query($query);
		$query
		= 'CREATE TABLE `membership` ('
		. '  `group` varchar(25) NOT NULL default "",'
		. '  `account` varchar(25) NOT NULL default "",'
		. '  `level` char(1) NOT NULL default "r",'
		. '  PRIMARY KEY  (`group`,`account`)'
		. ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		$db->query($query);
	}

}
?>