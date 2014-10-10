<?php

/**
 * Class for connecting to SQL databases and performing common operations.
 *
 * @package	App
 * @author 	Dmitriy Rudenskiy <dmitriy.rudenskiy@gmail.com>
 * @version 1.0.0
 */

namespace App\Lib;

class Db
{
    /**
     * Database connection
     *
     * @var object|resource|null
     */
    protected static $_connection = NULL;
	
	/**
	 * Pass the config to the adapter class constructor.
	 * 
	 * host           => (string) What host to connect to, defaults to localhost
	 * dbname         => (string) The name of the database to user
	 * username       => (string) Connect to the database as this username.
	 * password       => (string) Password associated with the username.
	 * 
	 * @param array $config
	 * @throws \InvalidArgumentException
	 */
	public static function setConect($config)
	{
		$listParams = [
			'host',
			'dbname',
			'username',
			'password'
		];
		
		// Check that the config contains the correct database array.
		foreach ($listParams as $param) {
			if (empty($config[$param])) {
				throw new \InvalidArgumentException(
					'empty or unset parameter "' 
					. $param . '" for connection to mysql'
				);
			}
		} 
		
		self::$_connection = new \PDO(
			sprintf(
				"mysql:host=%s;dbname=%s",
				$config['host'],
				$config['dbname']
			),
			$config['username'],
			$config['password']
		);
		
		self::$_connection->setAttribute(
			\PDO::ATTR_ERRMODE,
			\PDO::ERRMODE_EXCEPTION
		);
		
		if (empty($config['charset'])) {
			self::$_db->exec('set names ' . $config['charset']);
		}
	}
	
	/**
	 * Constructor.
	 *
	 * Check var connect an instance of \PDO
	 */
	public function __construct()
	{
		if (!self::$_connection instanceof \PDO) {
			throw new \RuntimeException('Not connect to db');
		}
	}
	
	/**
	 * Fetches the first row of the SQL result.
	 * 
	 * @param string $sql
	 * @param array $params
	 */
	public function fetchRow($sql, $params = NULL)
	{
		$stmt = $this->_getStatment($sql, $params);
		
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	
	/**
	 * Inserts a table row with specified data.
	 * 
	 * @param string $sql
	 * @param array $params
	 */
	public function insert($sql, $params = NULL)
	{
		$this->_getStatment($sql, $params);
	}
	
	/**
	 * Prepares and executes an SQL statement with bound data.
	 * 
	 * @param string $sql
	 * @param array $params
	 * @return unknown
	 */
	protected function _getStatment($sql, $params = NULL)
	{
		$stmt = self::$_connection->prepare($sql);
		
		if (is_array($params) && !empty($params)) {

			foreach ($params as $key => $value) {
				$stmt->bindParam(':' . $key, $params[$key]);
			}
		}
		
		$stmt->execute();
		
		return $stmt;
	}
}
