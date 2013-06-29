<?php

namespace James\NBAStatsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
	
	public function __construct() 
	{
		
	}
	
    /**
     * @Route("/", name="_nbastats_main")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
    	
    	$arg = array();

    	return $this->render('JamesNBAStatsBundle:Main:index.html.php', array('arg'=>$arg));
    }

}
