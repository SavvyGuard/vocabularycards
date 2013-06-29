<?php

// src/James/VocabBundle/DependencyInjection/WiktionaryAPIFetcher.php

namespace James\VocabBundle\DependencyInjection;

class WiktionaryAPIFetcher
{
    public function __construct()
    {

    }

    public function getDefinition($word)
    {
    	$api_base_url = 'http://en.wiktionary.org/w/api.php?format=json&action=query&titles=%s&prop=revisions&rvprop=content';
    	$api_word_url = sprintf($api_base_url, $word);
    	
    	$return = $this->setUpCurl($api_word_url);
    	$return = $this->decodeDefinition($return);
    
    	return $return;
    }
    
    public function decodeDefinition($definition) 
    {
		$star ='*';
		$definition = json_decode($definition);
		$definition = $definition->query->pages;
		$page_vars = get_object_vars($definition);
		$pages = array_keys($page_vars);
		$string = (string) $pages[0];
		$definition = $definition->$string->revisions[0]->$star;
		$definition = urldecode($definition);
		$matches = array();
		preg_match_all("/={3}[^\\\n=]{5,20}={3}/",$definition, $matches);
		$sections = $matches[0];
		var_dump($sections);
		die; 
		
	    return $definition;
    }
    public function setUpCurl($api_word_url)
    {
    	
    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_USERAGENT, 'User-Agent: GREVocabReview (http://jamesjwu.com/)');
    	curl_setopt ($curl, CURLOPT_URL, $api_word_url);
    	curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    	$return = curl_exec($curl);
    	curl_close ($curl);
    	
    	return $return;
    }
}
