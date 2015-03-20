<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\DependencyInjection\Definition;

class DefaultController extends Controller
{
    /**
     * @Route("/app/example", name="homepage")
     */
    public function indexAction(){
        return $this->render('default/index.html.twig');
    }

    /**
	 * @Route("/hello/{name}.{_format}",
	 *     defaults = {"_format"="html"},
	 *     requirements = { "_format" = "html|xml|json" },
	 *     name = "hello"
	 * )
	 */
    public function helloAction($name,  $_format){
        return $this->render('default/hello.'.$_format.'.twig', array(
            'name' => $name
        ));
    }
}
