<?php
define('BASE_PATH', realpath(__DIR__ . '/../src'));
define('DEBUG', 0);

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
