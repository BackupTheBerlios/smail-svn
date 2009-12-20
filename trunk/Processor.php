<?php

/**
 * Checks parameters and processes them as input. Provides a String as output.
 * @author maikel
 *
 */
interface Processor {

	/**
	 * Processes the given parameters.
	 * @param $simpleParams some content of $_GET
	 * @param $heavyParams some content of $_POST
	 * @return String output
	 */
	function processParams($simpleParams, $heavyParams);

}
?>