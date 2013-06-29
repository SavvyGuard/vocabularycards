<?php

// src/JamesWu/VocabBundle/DependencyInjection/MWAPIFetcher.php

namespace JamesWu\VocabBundle\DependencyInjection;

class MWAPIFetcher
{
    public function __construct()
    {

    }

    public function getDefinition($word)
    {
    	$api_base_url = 'http://www.dictionaryapi.com/api/v1/references/collegiate/xml/%s?key=d2c54b9f-c4fc-47aa-8896-8ddb764ff689';
    	$api_word_url = sprintf($api_base_url,urlencode(strtolower($word)));
    	
    	$return_string = $this->getWithCurl($api_word_url);
    	$formatted_string = str_replace(array('<d_link>', '</d_link>', '<fw>', '</fw>','<it>','</it>', ':', '<un>', '</un>'), '', $return_string);

    	$xml_object = new \SimpleXmlIterator($formatted_string);
    	$entries = array();
    	$entries = $this->getEntries($xml_object);
    	$results = array();
    	foreach ($entries as $entry) {
    		$definitions = $this->getDefinitionsFromEntry($entry);
    		if (empty($definitions))
    			continue;
    		$class = $this->getWordClassFromEntry($entry);
    		$result['definitions'] = $definitions;
    		$result['class'] = $class;
    		$results[] = $result;
    		
    	}

    	return $results;
    }
    
    public function getSummaryFromDt($dt) {
    	return trim((string) $dt);
    }
    
    public function getSynonymsFromDt($dt) {
    	$synonyms = array();
    	
    	foreach ($dt->sx as $sx) {
    		$synonym = (string) $sx;
    		$synonyms[] = $synonym;
    	}

    	return $synonyms;
    }
    
    public function getUseFromDt($dt) {
    	$use = $dt->vi;
    	
    	return (string) $use;
    }
    
    public function getDefinitionsFromEntry($entry) {
    	$def = $this->getDefFromEntry($entry);
    	
    	$dts = $this->getDtsFromDef($def);
    	
    	if (count($dts) == 0) {
    		return array();
    	}
    	 
    	$definitions = array();
    	
    	foreach ($dts as $dt){
    		$summary = $this->getSummaryFromDt($dt);
    		$synonyms = $this->getSynonymsFromDt($dt);
    		$use = $this->getUseFromDt($dt);
    		$definition['summary'] = $summary;
    		$definition['synonyms'] = $synonyms;
    		$definition['use'] = $use;
    		
    		$definitions[] = $definition;
    	}
  		
    	return $definitions;
    }
    public function getDtsFromDef($def) {
    	
    	return $def->dt	;
    	 
    }
    
    
    public function getEntries($xml_object) {
    	
    	return $xml_object->entry;
    	
    }
    
    public function getDefFromEntry($entry) {
    	 
    	$def = $entry->def;
    	
    	return $def;
    	
    }
    
    public function getWordClassFromEntry($entry) {
    
    	return (string) $entry->fl;
    
    }
    
    public function getWithCurl($api_word_url)
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

?>
