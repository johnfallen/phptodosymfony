<?php
namespace AppBundle\Controller\Cat;
/**
 * I am the CatController.
 *
 * @author John Allen
 * @version 1.0
 */

use AppBundle\Entity\Cat;
use AppBundle\Entity\Owner;
use AppBundle\Form\Cat\CatForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CatController extends Controller {
    
    /**
     * @Route("/cat", name="catIndex")
     */
    public function indexAction(){

        $em = $this->getDoctrine()->getManager();

        $catList = $em->getRepository('AppBundle:Cat')->findAllOrderedByName();

        return $this->render('cat/index.html.twig', array(
            'catList' => $catList
        ));
    }

    /**
     * @Route("/cat/edit/{id}", name="catEdit")
     */
    public function editAction( $id, Request $request ){

        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('AppBundle:Cat')->find( $id );
        $ownerList = $em->getRepository('AppBundle:Owner')->findAllOrderedByLastName();

        $form = $this->createForm( new CatForm(), $cat, array(
            'action' => $this->generateUrl('catSave', array('id' => $id)),
            'method' => 'post'
        ));

        return $this->render('cat/catform.html.twig', array(
            'form' => $form->createView(),
            'cat' => $cat,
            'ownerList' => $ownerList
        ));
    }

    /**
     * @Route("/cat/save/{id}", name="catSave")
     */
    public function saveAction( $id, Request $request ){

        $em = $this->getDoctrine()->getManager();

        $postData = $this->get('request')->request->all();

        var_dump($postData);


        return new Response('Hello', Response::HTTP_OK);
        //return $this->redirectToRoute('catIndex');
    }

    // ****************************** PRIVATE ****************************** //
    /**
	 * I return an associative array used by the front end to display messages.
	 *
	 * @param string $message  I am the message to display.  I default to an empty string.
	 * @param string $type  I am the type of message.  I default to an empty string.
	 * @return array
	 */
	private function getResponse( $message = '', $type = 'info' ) {
		$result = array();
		$result['message'] = $message;
		$result['type'] = $type;
		return $result;
	}
}

