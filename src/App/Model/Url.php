<?php

/**
 * Class model
 *
 * @package	App
 * @author 	Dmitriy Rudenskiy <dmitriy.rudenskiy@gmail.com>
 * @version 1.0.0
 */

namespace App\Model;

use App\Lib\Db as Db;
use App\Type\Url as Item;

class Url
{
	protected $_db;
	
	/**
	 * Constructor
	 *
	 * Instantiates the adapter class.
	 */
	public function __construct()
	{
		$this->_db = new Db;
	}

	/**
	 * Get the url of the alias.
	 * 
	 * @param string $alias
	 * @return string
	 */
	public function getUrl($alias)
	{
		$params = [
			'alias' => $alias
		];
		
		$sql = "
			SELECT url
			FROM url_shortener_list
			WHERE alias=:alias
		";
		
		$result = $this->_db->fetchRow($sql, $params);
		
		if (!empty($result['url'])) {
			return $result['url'];
		}
	}

    /**
     * Get the alias address.
     *
     * @param Item $itemUrl
     * @return string|null
     */
	public function getAlias(Item $itemUrl)
	{

		$params = [
			'hash' => $itemUrl->getHash()
		];
		
		$sql = "
			SELECT alias
			FROM url_shortener_list
			WHERE hash=:hash
		";
		
		$result = $this->_db->fetchRow($sql, $params);
		
		if (!empty($result['alias'])) {
			return $result['alias'];
		}
	}
	
	/**
	 * Add new row.
	 * 
	 * @param Item $itemUrl
	 */
	public function add(Item $itemUrl)
	{
		$params = $itemUrl->toArray();
		
		$sql = "INSERT INTO `url_shortener_list` (`alias`, `hash`, `url`)
				VALUES (:alias, :hash, :url)";
	
		$this->_db->insert($sql, $params);
	}
}