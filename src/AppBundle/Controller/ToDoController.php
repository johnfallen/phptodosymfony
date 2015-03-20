<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ToDoController extends Controller
{
    /**
     * @Route("/todo", name="todoHomepage")
     */
    public function indexAction(){

    	$todos = $this->get('ToDoService')->listToDo();

        return $this->render('todo/list.html.twig', array(
			'todos' => $todos
		));
    }


    /**
     * @Route("/todo/delete/{id}", name="todoDelete")
     */
    public function deleteAction( $id ){

    	$this->get('ToDoService')->deleteToDo($id);

    	$this->addFlash('response', $this->getResponse('The ToDo Was Deleted.', 'warning'));

    	return $this->redirectToRoute('todoHomepage');
    }

    /**
     * @Route("/todo/deletecompleted", name="deleteCompleted")
     */
    public function deleteCompletedAction(){

    	$this->get('ToDoService')->deleteCompleted();

    	$this->addFlash('response', $this->getResponse('Completed ToDo Have Been Deleted.', 'info'));

    	return $this->redirectToRoute('todoHomepage');
    }


    /**
     * @Route("/todo/edit/{id}", name="todoEdit")
     */
    public function editAction( $id ){

    	$todo = $this->get('ToDoService')->getToDo($id);

        return $this->render('todo/edit.html.twig', array(
			'todo' => $todo
		));
    }


    /**
     * @Route("/todo/save", name="todoSave")
     */
    public function saveAction(){

    	$toDoService = $this->get('ToDoService');
    	$postData = $this->get('request')->request->all();

    	$toDo = $toDoService->getToDo( $postData['id'] );

    	// handle checkbox
    	if ( isset($postData['complete']) ){
    		$postData['complete'] = true;
    	} else {
    		$postData['complete'] = false;
    	}

    	$toDo->setTask($postData['task']);
		$toDo->setComplete($postData['complete']);

		$toDoService->saveToDo( $toDo );

    	$this->addFlash('response', $this->getResponse('The ToDo Was Saved.', 'success'));

    	return $this->redirectToRoute('todoHomepage');
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

