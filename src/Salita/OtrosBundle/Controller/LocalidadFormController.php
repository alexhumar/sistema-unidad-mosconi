<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\LocalidadType;
use Salita\OtrosBundle\Entity\Localidad;
use Salita\OtrosBundle\Clases\MyController;

class LocalidadFormController extends MyController
{	
	/*ATENCION: NO HAY RUTA QUE REFERENCIE ESTE CONTROLADOR.*/

	/*Alta de localidad (fase GET)*/
    public function newAction()
    {
        $localidad = new Localidad();
        $form = $this->createForm(new LocalidadType(), $localidad);
        return $this->render(
           			'SalitaOtrosBundle:LocalidadForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    /*Alta de localidad (fase POST)*/
    public function newProcessAction()
    {
    	$session = $this->getSession();
    	$localidad = new Localidad();
    	$form = $this->createForm(new LocalidadType(), $localidad);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->saveLocalidad($localidad);
   			$mensaje = 'La localidad se cargo exitosamente en el sistema';
   			$session->set('mensaje', $mensaje);
   			$session->getFlashBag()->add('mensaje', $mensaje);
   			$nextAction = $form->get('guardarynuevo')->isClicked()
   				? 'alta_localidad'
   				: 'resultado_operacion';
   			return $this->redirect($this->generateUrl($nextAction));
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al cargar la localidad al sistema';
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion'));
   		}
    }
}