<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\MetodoEstudioType;
use Salita\OtrosBundle\Entity\MetodoEstudio;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class MetodoEstudioFormController extends MyController
{
	
    /*Alta de metodo de estudio*/
    public function newAction()
    {
    	$metodo = new MetodoEstudio();
    	$form = $this->createForm(new MetodoEstudioType(), $metodo);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->saveMetodoDeEstudio($metodo);  			
   			/*$session = $this->getSession();
   			$session->set('mensaje', $translator->trans($mensaje));
   			$session->getFlashBag()->add('mensaje', $translator->trans($mensaje));*/
   			$nextAction = $form->get('guardarynuevo')->isClicked()
   				? 'alta_metodoestudio'
   				: 'resultado_operacion';
   			$sessionManager = $this->getSessionManager();
   			$translator = $this->getTranslator();
   			$mensaje = $this->getDialogsManager()->cargaMetodoEstudioExitoMsg();
   			$sessionManager->setMensajeResultadoOperacion($nextAction, $translator->trans($mensaje));
   			return $this->redirect($this->generateUrl($nextAction));
   		}
   		return $this->render(
   				'SalitaOtrosBundle:MetodoEstudioForm:new.html.twig',
   				array('form' => $form->createView())
   		);
    }
}