<?php

// src/James/NBAStatsBundle/DependencyInjection/Player.php

namespace James\NBAStatsBundle\DependencyInjection;

class Player
{
	private $name;
	private $box_stats;
	private $adv_stats;
	private $current_box;
	private $current_adv;
	
    public function __construct($db)
    {
		$this->Db = $db;
    }

    public function setPlayer($last, $first)
    {
		$this->name = $this->checkPlayer($last, $first);
    	return $this->name;
    }
    
    public function getPlayer()
    {
    	return $this->name;
    }
    
    public function getBoxStats()
    {
    	if (empty($this->box_stats))
    		$this->retrieveBoxStats();
    		
    	return $this->box_stats;
    }
    
    public function getAdvStats()
    {
    	if (empty($this->adv_stats))
    		$this->retrieveAdvStats();
    	
    	return $this->adv_stats;
    }
    
    public function getChangedStats()
    {
    	if (empty($this->changed_stats))
    		$this->retrieveChangedStats();
    	
    	return $this->changed_stats;	
    }
    
    public function getCurrentBox()
    {
    	if (empty($this->current_box)) 
    		$this->retrieveCurrentBox();
    	
    	return $this->current_box;
    }
    
    public function getCurrentAdv()
    {
    	if (empty($this->current_box))
    		$this->retrieveCurrentAdv();
    	
    	return $this->current_adv;
    }
    
    private function retrieveChangedStats()
    {
    	$sql = 'SELECT 
    				box.G - current.G as G,
    				box.MP - current.MP as MP,
    				box.TRB - current.TRB as TRB,
    				box.AST - current.AST as AST,
    				box.STL - currentSTL as STL,
    				box.TOV - current.TOV as TOV,
    				box.PF - current.PF as PF,
    				box.PTS - current.PTS as PTS,
    				box.FTA - current.FTA as FT,
    				box.FT% - current.FT% as FT%,
    				box.FGA - current.FG% as FG%,
    				box.3PA - current.3PA as 3PA,
    				box.3P% - current.3P% as 3P%	
    					FROM PLAYER_BOX AS box INNER JOIN CURRENT_BOX AS current ON (box.Name = current.Name)
    						WHERE box.Name = :name';
    	$params = array('name' => $this->name);
    	
    	$changed_stats = $this->Db->get($sql, $params);
    	$changed_stats = null;
    	 
    	foreach($changed_years as $year => $changed_year) {
    		foreach(array_keys($changed_year) as $key_name) {
	    		if (is_int($key_name))
	    			unset($changed_years[$year][$key_name]);
    		}
    	}
    	
    	$changed_stats = $box_years;
    	
    	$this->changed_stats = $changed_stats;
    	return $changed_stats;
    }
    
    private function retrieveCurrentBox()
    {
    
    	
    }
	
    private function retrieveCurrentAdv()
    {
    	
    }
   
    private function retrieveAdvStats() {
    	$sql = 'SELECT * from PLAYER_ADV
    		WHERE Name LIKE :name';
    	
    	$params = array('name' => $this->name);
    	 
    	$adv_years = $this->Db->get($sql, $params);
    	$adv_stats = null;
    	 
    	foreach($adv_years as $year => $adv_year) {
    		foreach(array_keys($adv_year) as $key_name) {
	    		if (is_int($key_name))
	    			unset($adv_years[$year][$key_name]);
    		}
    	}
    	
    	$adv_stats = $adv_years;
    	
    	$this->adv_stats = $adv_stats;
    	return $adv_stats;
    }
    
    private function retrieveBoxStats() {
    	$sql = 'SELECT * from PLAYER_BOX
    			WHERE Name LIKE :name';
    	
    	$params = array('name' => $this->name);
    	 
    	$box_years = $this->Db->get($sql, $params);
    	$box_stats = null;
    	 
    	foreach($box_years as $year => $box_year) {
    		foreach(array_keys($box_year) as $key_name) {
	    		if (is_int($key_name))
	    			unset($box_years[$year][$key_name]);
    		}
    	}
    	$box_stats = $box_years;
    	
    	$this->box_stats = $box_stats;
    	return $box_stats;
    }
    
    private function checkPlayer($last, $first) 
    {
    	$sql = 'SELECT Name from PLAYER_BOX 
    				WHERE Name LIKE CONCAT(:last, ", ", :first)
    					ORDER BY Year DESC';
    	
    	$params = array('first' => $first,
    					'last' => $last);
    	$result = $this->Db->get($sql, $params);
    	$player = null;
    	if (isset($result[0]['Name']))
    		$player = $result[0]['Name'];
    	
    	return $player;
    }
    
    protected function getJamesStat($last, $first)
    {
    	$sql = 'SELECT adv.Year, adv.Name, (WP48 + LM*.01) as aWP48, LM*.01 as adjustment, WP48  
    				FROM PLAYER_ADV AS adv INNER JOIN PLAYER_CHART AS chart 
    					ON (adv.year = chart.year AND adv.Name = chart.Name) 
    				WHERE Name = CONCAT(:last, ", ", :first)
    					ORDER BY Year DESC';
    	$params = array('first' => $first,
    					'last' => $last);
    	$stats = $this->Db->get($sql, $params);
    	 
    	foreach($result as $year => $stat) {
    		foreach(array_keys($stat) as $key_name) {
	    		if (is_int($key_name))
	    			unset($stats[$year][$key_name]);
    		}
    	}
    	
    	$this->james_stats = $stats;
    	
    	return $stats;
    	
    }
  
}



?>