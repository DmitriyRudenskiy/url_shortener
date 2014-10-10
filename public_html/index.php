<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


define('BASE_PATH', realpath(__DIR__ . '/../src'));
define('DEBUG', 1);

try {
	include BASE_PATH . '/App/Lib/Loader.php';
	new App\Lib\Loader;
	
	(new App\Bootstrap)->run();
} catch (Exception $e) {
	if (DEBUG) {
		echo $e->getMessage();
	} else {
		echo 'Error';
	}
}