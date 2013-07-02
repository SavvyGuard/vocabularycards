<?php

namespace JamesWu\VocabBundle\Controller;

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
     * @Route("/", name="jameswuvocabbundle.main.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
    	
    	$arg = array();
    	
	return $this->render('JamesWuVocabBundle:Main:index.html.php', array('arg'=>$arg));
    }
   
    /**
     * @Route("/about", name="jameswuvocabbundle.main.about")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aboutAction()
    {
    
    	$arg = array();
    
    	return $this->render('JamesWuVocabBundle:Main:about.html.php', array('arg'=>$arg));
    }
    
    /**
     * @Route("/contact", name="jameswuvocabbundle.main.contact")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction()
    {
    	 
    	$arg = array();
    
    	return $this->render('JamesWuVocabBundle:Main:contact.html.php', array('arg'=>$arg));
    }
    
    /**
     * @Route("/random", name="jameswuvocabbundle.main.word.random")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getRandomWordAction()
    {
    	$this->wg = $this->get('word_generator');
    	$word = $this->wg->generateWord();
    	
    	$jsonObj = json_encode($word);
    	return new Response($jsonObj, 200, array('Vary' => 'Accept', 'Content-type' => 'application/json'));
    }
    
    /**
     * @Route("/status", name="jameswuvocabbundle.main.word.status")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setWordStatus()
    {
    	$request = Request::createFromGlobals();
    	$this->wm = $this->get('word_manager');
    	
    	$word_id = $request->request->get('word_id', '0');
    	$status = $request->request->get('status', '0');
    	
    	$result = $this->wm->setWordStatus($word_id, $status);
    	 
    	$jsonObj = json_encode($result);
    	return new Response($jsonObj, 200, array('Vary' => 'Accept', 'Content-type' => 'application/json'));
    }
    
    /**
     * @Route("/word/{word}", defaults={"word" = "game"}, name="jameswuvocabbundle.main.word.def")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getWordDefAction($word)
    {
    	$request = Request::createFromGlobals();
    	$dictionary = $this->get('dictionary');
    	
    	$definition = $dictionary->getDefinition((string) $word);

        $jsonObj = json_encode($definition);
	return new Response($jsonObj, 200, array('Vary' => 'Accept', 'Content-type' => 'application/json'));
    }
}
