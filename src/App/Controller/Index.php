<?php
/**
 * Class controller
 *
 * @package	App
 * @author 	Dmitriy Rudenskiy <dmitriy.rudenskiy@gmail.com>
 * @version 1.0.0
 */

namespace App\Controller;

use App\Model\Url as Url;
use App\Type\Url as Item;

class Index
{
	protected $_model;
	
	const PROTOCOL = 'http';
	
	/**
	 * Constructor
	 *
	 * Instantiates the model URL.
	 */
	public function __construct()
	{
		$this->_model = new Url;
	}
	
	/**
	 * Form
     *
     * @throws \RuntimeException
	 */
	public function formAction()
	{
		if (!empty($_POST['url'])) {
			$this->_addNewUrl($_POST['url']);
		}

		if (!defined('BASE_PATH')) {
			throw new \RuntimeException('Not setup "BASE_PATH"');
		}
		
		include BASE_PATH . '/App/View/index.inc';
	}
	
	/**
	 * Redirect
	 * 
	 * @param string $alias
	 */
	public function redirectAction($alias)
	{
		$url = $this->_model->getUrl($alias);
		
		if (!empty($url)) {
			$this->_redirect($url);
		} else {
			$this->errorAction();
		}
	}
	
	/**
	 * Not found URL.
	 */
	public function errorAction()
	{
		header("HTTP/1.1 404 Not Found");
		exit();
	}
	
	/**
	 * Redirect to another URL.
	 *
	 * @param string $url
	 */
	protected function _redirect($url)
	{
		if (0 !== strpos($url, self::PROTOCOL)) {
			$url = self::PROTOCOL . "://" . $url;
		}
		
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $url);
		exit();
	}
	
	/**
	 * Processing a request for adding.
	 */
	protected function _addNewUrl($url)
	{
		$selfSite = strpos($url, $_SERVER['HTTP_HOST']);
		
		if ($selfSite !== FALSE && $selfSite <= strlen(self::PROTOCOL)) {
			$this->_sendResponce(
				'This URL cannot be shortened. Please try another one.'
			);
		}
		
		$itemUrl = (new Item)->init($url);
			
		$alias = $this->_model->getAlias($itemUrl);
		
		if (empty($alias)) {
			do {
				$url = $this->_model->getUrl($itemUrl->getAlias());

				if (!empty($url)) {
					$itemUrl->regenerateAlias();
				}
			
			} while (!empty($url));
			
			$this->_model->add($itemUrl);
			$alias = $itemUrl->getAlias();
		}
		
		$this->_sendResponce($this->_createUrl($alias));
	}
	
	/**
	 * Create shorter URL.
	 * 
	 * @param string $alias
	 * @return string
	 */
	protected function _createUrl($alias)
	{
		return sprintf(
			"%s://%s/%s",
			self::PROTOCOL,
			$_SERVER['HTTP_HOST'],
			$alias
		);
	}
	
	/**
	 * Send response.
	 * 
	 * @param string $response
	 */
	protected function _sendResponce($response)
	{
		echo $response;
		exit();
	}
}