<?php

/**
 * Concrete base class for bootstrap classes.
 *
 * @package	App
 * @author 	Dmitriy Rudenskiy <dmitriy.rudenskiy@gmail.com>
 * @version 1.0.0
 */

namespace App;

use App\Lib\Db as Db;

class Bootstrap
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->_initDb();
	}
	
	/**
	 * Initialize data bases
	 * @throws \RuntimeException
	 */
	protected function _initDb()
	{
		if (!defined('BASE_PATH')) {
			throw new \RuntimeException('Not setup "BASE_PATH"');
		}
		
		Db::setConect(include BASE_PATH . '/App/config/db.php');
	}
	
	/**
	 * Run the application
	 */
	public function run()
	{
		$controller = new Controller\Index;

		$request = str_replace('/', '', $_SERVER["REQUEST_URI"]);
		
		if (empty($request)) {
			$controller->formAction();
		} else if (strlen($request) == Type\Url::LENGTH_ALIAS) {
			$controller->redirectAction($request);
		} else {
			$controller->errorAction($request);
		}
	}
}