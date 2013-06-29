<?php

namespace James\NBAStatsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AjaxController extends Controller
{
	
	public function __construct() 
	{
		
	}
	
    /**
     * @Route("/{lname}/{fname}",defaults={"lname" = "James", "fname" = "Lebron"}, name="_nbastats_ajax")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function playerAction($lname, $fname)
    {
    	$request = Request::createFromGlobals();
    	$player = $this->get('player');
    	$player->setPlayer($lname, $fname);
    	$box = $player->getBoxStats();
    	$adv = $player->getAdvStats();
		
    	$result = array('box' => $box, 
    					'adv' => $adv);
        $jsonObj = json_encode($result);
		return new Response($jsonObj, 200, array('Vary' => 'Accept', 'Content-type' => 'application/json'));
    }

}
