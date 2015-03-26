<?php
namespace AppBundle\Controller;
/**
 * I am the CatController.
 *
 * @author John Allen
 * @version 1.0
 */

use AppBundle\Entity\Cat;
use AppBundle\Entity\Owner;
use AppBundle\Form\CatForm;
use AppBundle\Form\OwnerForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CatController extends Controller {

    /**
     * I am the default action for Cat part of the application.
     *
     * @Route("/cat", name="catIndex")
     * @return Response
     */
    public function indexAction(){

        $em = $this->getDoctrine()->getManager();

        $catList = $em->getRepository('AppBundle:Cat')->findAllOrderedByName();

        return $this->render('cat/index.html.twig', array(
            'catList' => $catList
        ));
    }


    /**
     * I delete a cat by ID
     *
     * @Route("/cat/delete/{id}", name="catDelete")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function catDeleteAction( $id ){

        $em = $this->getDoctrine()->getManager();

        $cat = $em->getRepository('AppBundle:Cat')->find( $id );

        $em->remove($cat);
        $em->flush();

        $this->addFlash('response', $this->getResponse('The Cat has been put down. :(', 'warning'));

        return $this->redirectToRoute('catIndex');
    }

    /**
     * I display the Cat Edit form.
     *
     * @Route("/cat/edit/{id}", name="catEdit")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function catEditAction( $id, Request $request ){

        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('AppBundle:Cat')->find( $id );
        $ownerList = $em->getRepository('AppBundle:Owner')->findAllOrderedByLastName();

        $form = $this->createForm( new CatForm(), $cat, array(
            'action' => $this->generateUrl( 'catSave' ),
            'method' => 'post'
        ));

        return $this->render('cat/catform.html.twig', array(
            'form' => $form->createView(),
            'cat' => $cat,
            'ownerList' => $ownerList
        ));
    }

    /**
     * I am the action used for saving a Cat
     *
     * @Route("/cat/save", name="catSave")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function saveAction( Request $request ){

        $em = $this->getDoctrine()->getManager();
        $postData = $request->request->all();

        // TODO: normally this would be put into an ORM service where we would
        // just do ORMService->get('objectName', $id) and it would pass back a
        // new or persisted object... will to this later...

        // new cat or old cat. Handle based on what we were passed as an ID.
        if ( strlen( $postData['cat']['id'] ) > 0 ){
            $cat = $em->getRepository('AppBundle:Cat')->find( $postData['cat']['id'] );
        } else {
            $cat = new Cat();
        }

        // populate the cat properties
        $cat->setName($postData['cat']['name']);
        $cat->setDescription($postData['cat']['description']);

        // populate if they decided on an owner
        if ( array_key_exists( 'owner', $postData ) ){
            $owner = $em->getRepository('AppBundle:Owner')->find( $postData['owner']['id'] );
            $cat->setOwner($owner);
        }

        $errors = $cat->validate();

        if ( count($errors) > 0 ){

            $ownerList = $em->getRepository('AppBundle:Owner')->findAllOrderedByLastName();

            $form = $this->createForm( new CatForm(), $cat, array(
                'action' => $this->generateUrl( 'catSave' ),
                'method' => 'post'
            ));

            $this->addFlash('response', $this->getResponse('There were ERRORS! Please correct them!', 'danger'));

            return $this->render('cat/catform.html.twig', array(
                'form' => $form->createView(),
                'cat' => $cat,
                'ownerList' => $ownerList,
                'errors' => $errors
            ));
        }

        $em->persist($cat);
        $em->persist($owner);
        $em->flush();

        $this->addFlash('response', $this->getResponse('The cat was saved perrrrrfectly!', 'success'));

        return $this->redirectToRoute('catIndex');
    }

    /**
     * I display an Cat Owner form and when submitted I save the Cat Owner
     *
     * @Route("/cat/owner/edit/{id}", name="catOwnerEdit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function catOwnerEdit( $id, Request $request ){

        $em = $this->getDoctrine()->getManager();
        $owner = $em->getRepository('AppBundle:Owner')->find( $id );

        $form = $this->createForm( new OwnerForm(), $owner );

        $form->handleRequest($request);

        if ($form->isValid()) {

            // this is stupid, and the documentation is incorrect. I cant save
            // a NEW owner object so I need to create a new one and populate it.
            if ($id == 0){
                $postData = $request->request->all();
                $owner = new Owner();
                $owner->setFirstName($postData['owner']['firstName']);
                $owner->setLastName($postData['owner']['lastName']);
            }

            $em->persist($owner);
            $em->flush();

            $this->addFlash('response', $this->getResponse('The Cat Owner was saved.', 'success'));

            return $this->redirectToRoute('catOwnerList');
        }

        // don't show the error when were creating a new Owner.
        if ( !$form->isValid() &&  $form->isSubmitted() ){
            $this->addFlash('response', $this->getResponse('There were ERRORS! Please correct them!', 'danger'));
        }

        return $this->render('cat/ownerform.html.twig', array(
            'form' => $form->createView(),
            'owner' => $owner
        ));
    }


    /**
     * I delete a Cat Owner
     *
     * @Route("/cat/owner/delete/{id}", name="catOwnerDelete")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function catOwnerDelete( $id ){

        $em = $this->getDoctrine()->getManager();

        $owner = $em->getRepository('AppBundle:Owner')->find( $id );

        if ($owner->hasCats()){

            $this->addFlash('response', $this->getResponse('The Cat Owner Owns Cats! How can you put cats on the street?', 'danger'));

            return $this->redirectToRoute('catOwnerList');

        } else {

            $em->remove($owner);
            $em->flush();

            $this->addFlash('response', $this->getResponse('The Cat Owner was deleted.', 'success'));

            return $this->redirectToRoute('catOwnerList');
        }
    }

    /**
     * I list all the owners
     *
     * @Route("/cat/owner", name="catOwnerList")
     * @return Response
     */
    public function catOwnerList(){

        $em = $this->getDoctrine()->getManager();

        $ownerList = $em->getRepository('AppBundle:Owner')->findAllOrderedByLastName();

        return $this->render('cat/ownerlist.html.twig', array(
            'ownerList' => $ownerList
        ));
    }

    // ****************************** PRIVATE ****************************** //
    /**
	 * I return an associative array used by the front end to display messages.
	 *
	 * @param string $message  I am the message to display.  I default to an
     * empty string.
	 * @param string $type  I am the type of message.  I default to an empty
     * string.
	 * @return array
	 */
	private function getResponse( $message = '', $type = 'info' ) {
		$result = array();
		$result['message'] = $message;
		$result['type'] = $type;
		return $result;
	}
}

