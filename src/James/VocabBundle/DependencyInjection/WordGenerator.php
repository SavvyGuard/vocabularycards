<?php

// src/James/VocabBundle/DependencyInjection/WordGenerator.php

namespace James\VocabBundle\DependencyInjection;

class WordGenerator
{
    public function __construct(DbFetcher $db)
    {
		$this->Db = $db;
    }

    public function generateWord()
    {
    	$sql = 'SELECT 
    				word_text, 
    				words.word_id, 
    				(10*RAND() + status) AS rank 
    					FROM MY_WORDS AS my_words 
    					INNER JOIN WORDS AS words 
    					 ON (words.word_id = my_words.word_id) 
    				ORDER BY rank DESC LIMIT 1';
    	$params = array();
    	 
    	$result = $this->Db->get($sql, $params);
    	
    	$word = '';
    	if (!empty($result[0]))
    		$word = $result[0];
    	
    	return $word;
    }

  
}



?>