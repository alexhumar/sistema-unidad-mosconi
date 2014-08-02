<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\LocalidadType;
use Salita\OtrosBundle\Entity\Localidad;
use Salita\OtrosBundle\Clases\MyController;

class LocalidadFormController extends MyController
{	
	/*ATENCION: NO HAY RUTA QUE REFERENCIE ESTE CONTROLADOR.*/
    
    /*Alta de localidad*/
    public function newAction()
    {
    	$localidad = new Localidad();
    	$form = $this->createForm(new LocalidadType(), $localidad);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->saveLocalidad($localidad);
   			$mensaje = $this->getDialogsManager()->cargaLocalidadExitoMsg();
   			$translator = $this->getTranslator();
   			$session = $this->getSession();
   			$session->set('mensaje', $translator->trans($mensaje));
   			$session->getFlashBag()->add('mensaje', $translator->trans($mensaje));
   			$nextAction = $form->get('guardarynuevo')->isClicked()
   				? 'alta_localidad'
   				: 'resultado_operacion';
   			return $this->redirect($this->generateUrl($nextAction));
   		}
        return $this->render(
           			'SalitaOtrosBundle:LocalidadForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
}