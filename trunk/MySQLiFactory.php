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
		return $this->instance;
	}
	
	private static function createInstance() {
		if (!self::configIsReadable()) {
			die('MySQL configuration file is not readable.' . "\n");
		}
		include self::$CONFIG_FILE;
		self::$INSTANCE = new mysqli($host, $user, $passwd, $dbname);
	}

}
?>