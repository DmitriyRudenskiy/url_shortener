<?php
namespace App\Type;

class Url
{
	const LENGTH_ALIAS = 5;
	
	/**
	 * @var string
	 */
	 protected $_alias;
	 
	 /**
	  * @var string
	  */
	 protected $_url;
	 
	 /**
	  * Initialization data
	  * 
	  * @param string $url
	  */
	 public function init($url)
	 {
	 	$this->_alias = $this->_createAlias();
	 	$this->_url = urldecode($url);
	 	
	 	return $this;
	 }
	 
	 /**
	  * Get alias
	  */
	 public function getAlias()
	 {
	 	return $this->_alias;
	 }
	 
	 /**
	  * Get hash URL
	  * 
	  * @retrun string
	  */
	 public function getHash()
	 {
	 	return md5($this->_url);
	 }
	 
	 /**
	  * Returns an array representation
	  *
	  * @return array
	  */
	 public function toArray()
	 {
	 	return [
	 		'alias' => $this->_alias,
	 		'hash' => md5($this->_url),
	 		'url' => $this->_url
	 	];
	 }
	 
	 /**
	  * Create new alias
	  */
	 public function regenerateAlias()
	 {
	 	$this->_alias = $this->_createAlias();
	 }
	 
	 /**
	  * Create alias for url
	  */
	 protected function _createAlias()
	 {
	 	$result = '';
	 
	 	$listChar = $this->_getListChar();
	 
	 	for ($i = 0; $i < self::LENGTH_ALIAS; $i++) {
	 		 $char = $listChar[rand(0, (sizeof($listChar) - 1))];
	 		 
	 		 if (!is_numeric($char) && rand(0, 1) == 1) {
	 		 	$char = strtolower($char);
	 		 }
	 		
	 		 $result .= $char;
	 	}
	 
	 	return $result;
	 }
	 
	 /**
	  * Get a list of characters
	  * 
	  * @return array
	  */
	 protected function _getListChar()
	 {
	 	return [
	 		'A', 'B', 'C', 'D', 'E', 'F',
	 		'G', 'H', 'I', 'J', 'K', 'L',
	 		'M', 'N', 'O', 'P', 'R', 'S',
	 		'T', 'U', 'V', 'X', 'Y', 'Z',
	 		'1', '2', '3', '4', '5', '6',
	 		'7', '8', '9', '0'
	 	];
	 }
}