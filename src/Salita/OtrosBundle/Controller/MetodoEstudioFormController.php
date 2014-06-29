<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\MetodoEstudioType;
use Salita\OtrosBundle\Entity\MetodoEstudio;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class MetodoEstudioFormController extends MyController
{
	
	/*Alta de metodo de estudio (fase GET)*/
    public function newAction()
    {
        $metodo = new MetodoEstudio();
        $form = $this->createForm(new MetodoEstudioType(), $metodo);
        return $this->render(
           			'SalitaOtrosBundle:MetodoEstudioForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    /*Alta de metodo de estudio (fase POST)*/
    public function newProcessAction()
    {
    	$session = $this->getSession();
    	$metodo = new MetodoEstudio();
    	$form = $this->createForm(new MetodoEstudioType(), $metodo);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->saveMetodoDeEstudio($metodo);
   			$mensaje = 'El metodo de estudio se cargo exitosamente en el sistema';
   			$session->set('mensaje', $mensaje);
   			$session->getFlashBag()->add('mensaje', $mensaje);
   			$nextAction = $form->get('guardarynuevo')->isClicked()
   				? 'alta_metodoestudio'
   				: 'resultado_operacion';
   			return $this->redirect($this->generateUrl($nextAction));
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar el metodo de estudio al sistema';
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion'));
   		}
    }
}