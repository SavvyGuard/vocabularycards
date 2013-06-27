<?php

// src/James/VocabBundle/DependencyInjection/WordManager.php

namespace James\VocabBundle\DependencyInjection;

class WordManager
{
    public function __construct(DbFetcher $db)
    {
		$this->Db = $db;
    }

    public function setWordStatus($word_id, $status)
    {
    	$sql = 'INSERT INTO MY_WORDS (word_id, status) 
    				VALUES (:word_id, :status) 
    					ON DUPLICATE KEY UPDATE status = IF(status + :status < 0,0,status + :status)';
    	$params = array('word_id'  => (int) $word_id,
    					'status' => (int) $status);
    	 
    	$result = $this->Db->set($sql, $params);
    	
    	return $result;
    }

  
}



?>