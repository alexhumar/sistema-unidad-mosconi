<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\PartidoType;
use Salita\OtrosBundle\Entity\Partido;
use Salita\OtrosBundle\Clases\MyController;

class PartidoFormController extends MyController
{
	/*ATENCION: ninguno de los controladores de esta clase tiene rutas asociadas.*/
    
    /*Alta de partido*/
    public function newAction()
    {
    	$partido = new Partido();
    	$form = $this->createForm(new PartidoType(), $partido);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->savePartido($partido);
   			$mensaje = $this->getDialogsManager()->cargaPartidoExitoMsg();
   			$translator = $this->getTranslator();
   			$session = $this->getSession();
   			$session->set('mensaje', $translator->trans($mensaje));
   			$session->getFlashBag()->add('mensaje', $translator->trans($mensaje));
   			$nextAction = $form->get('guardarynuevo')->isClicked()
   				? 'alta_partido'
   				: 'resultado_operacion';
   			return $this->redirect($this->generateUrl($nextAction));
   		}
        return $this->render(
           			'SalitaOtrosBundle:PartidoForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
      
    function listAction()
    {
        $repoPartidos = $this->getReposManager()->getPartidosRepo();
        $partidos = $repoPartidos->encontrarTodosOrdenadosPorNombre();
        return $this->render(
        			'SalitaOtrosBundle:PartidoForm:listado.html.twig',
        			array('partidos' => $partidos)
        		);
    }
    
    /*Modificacion de partido*/
    public function modifAction($id)
    {
    	$repoPartidos = $this->getReposManager()->getPartidosRepo();
    	$partido = $repoPartidos->find($id);
    	$translator = $this->getTranslator();
    	if(!$partido)
    	{
    		$mensaje = $this->getDialogsManager()->getPartidoInexistenteMsg();
    		throw $this->createNotFoundException($translator->trans($mensaje));
    	}
    	$form = $this->createForm(new PartidoType(), $partido);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->updatePartido($partido);
   			$session = $this->getSession();
   			$mensaje = $this->getDialogsManager()->modificacionPartidoExitoMsg();
   			$session->set('mensaje', $translator->trans($mensaje));
   			return $this->redirect($this->generateUrl('resultado_operacion'));
   		}
        return $this->render(
           			'SalitaOtrosBundle:PartidoForm:modif.html.twig',
           			array('form' => $form->createView(),'id' => $id)
           		);
    }
}