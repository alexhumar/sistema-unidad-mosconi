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
   			$mensaje = 'El metodo de estudio se cargo exitosamente en el sistema';
   			$session = $this->getSession();
   			$session->set('mensaje', $mensaje);
   			$session->getFlashBag()->add('mensaje', $mensaje);
   			$nextAction = $form->get('guardarynuevo')->isClicked()
   				? 'alta_metodoestudio'
   				: 'resultado_operacion';
   			return $this->redirect($this->generateUrl($nextAction));
   		}
   		return $this->render(
   				'SalitaOtrosBundle:MetodoEstudioForm:new.html.twig',
   				array('form' => $form->createView())
   		);
    }
}