<?php

/**
 * Class for loading classes and files.
 *
 * @package	App
 * @author 	Dmitriy Rudenskiy <dmitriy.rudenskiy@gmail.com>
 * @version 1.0.0
 */

namespace App\Lib;

class Loader
{
	const NAME_SEPARATOR = '\\';
	const PATH_SEPARATOR = '/';
	const FILE_EXTENSION = '.php';
	
	/**
	 * Implementation for supporting class autoloading.
	 * 
	 * @throws \RuntimeException
	 */
	public function __construct()
	{
		if (!defined('BASE_PATH')) {
			throw new \RuntimeException('Not setup "BASE_PATH"');
		}
		
		spl_autoload_register(array($this,'loadClass'));
	}

	/**
	 * Loads a class from a PHP file.
	 *
     * @param string $class
	 * @return boolean
     * @throws \InvalidArgumentException
     */
	public function loadClass($class)
	{
		if (!is_string($class) || empty($class)) {
			throw new \InvalidArgumentException('Error class name');
		}
		
		$fileName = BASE_PATH . self::PATH_SEPARATOR 
			.str_replace(self::NAME_SEPARATOR, self::PATH_SEPARATOR, $class)
			. self::FILE_EXTENSION;
		
		if (!file_exists($fileName)) {
			return FALSE;
		}
		
		include $fileName;
		return TRUE;
	}
}

