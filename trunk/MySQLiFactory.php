<?php

/**
 * Provides access to one instance of mysqli.
 * @author maikel
 *
 */
class MySQLiFactory {
	
	private static $CONFIG_FILE = 'mysql.php';
	
	private static $INSTANCE = null;
	
	/**
	 * Returns the one and only instance or dies.
	 * @return mysqli instance
	 */
	public static function getInstance() {
		if ($instance == null) {
			self::createInstance();
		}
		return $this->instance;
	}
	
	private static function createInstance() {
		if (!is_readable(self::$CONFIG_FILE)) {
			die('MySQL configuration file is not readable.' . "\n");
		}
		if (!is_file(self::$CONFIG_FILE)) {
			die('MySQL configuration file is no file.' . "\n");
		}
		include self::$CONFIG_FILE;
		self::$INSTANCE = new mysqli($host, $user, $passwd, $dbname);
	}

}
?>