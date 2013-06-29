<?php 

// src/JamesWu/VocabBundle/DependencyInjection/DbFetcher.php

namespace JamesWu\VocabBundle\DependencyInjection;

/**
 * Class DbFetcher
 * Purpose: facilitates getting data from a database
 * @version 1.0 3/28/2012
 * @author jameswu
 *
 */

class DbFetcher
{
	public $db_connection;
	
	public function __construct($db_connection) {

		try {
			$this->db_connection = $db_connection;
		}
		catch (Exception $e) {
		}

	}
	
	/**
	 * use for select statements
	 * @param string $sql
	 * @param array $params
	 * @return array
	 */
	public function get($sql,$params)
	{
		try {
			$stmt = $this->db_connection->executeQuery($sql, $params);
			return $stmt->fetchAll();
		}
		catch (PDOException $e) {
		}
	}
	
	/**
	 * use for insert, update, and delete
	 * @param string $sql
	 * @param array $params
	 * @return array
	 */
	public function set($sql, $params)
	{
		try {
			$count = $this->db_connection->executeUpdate($sql, $params);
			return $count;
		}
		
		catch (PDOException $e) {
		}
	}


}
?>
