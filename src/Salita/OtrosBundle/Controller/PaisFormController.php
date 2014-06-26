<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\PaisType;
use Salita\OtrosBundle\Entity\Pais;
use Salita\OtrosBundle\Clases\MyController;

class PaisFormController extends MyController
{
	/*ATENCION: NO HAY RUTA QUE REFERENCIE ESTE CONTROLADOR.*/
	
	/*Alta de pais (fase GET)*/
    public function newAction()
    {
        $pais = new Pais();
        $form = $this->createForm(new PaisType(), $pais);
        return $this->render(
           			'SalitaOtrosBundle:PaisForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    /*Alta de pais (fase POST)*/
    public function newProcessAction()
    {
    	$session = $this->getSession();
    	$pais = new Pais();
    	$form = $this->createForm(new PaisType(), $pais);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->savePais($pais);
   			$mensaje = 'El pais se cargo exitosamente en el sistema';
   			$session->set('mensaje', $mensaje);
   			$session->getFlashBag()->add('mensaje', $mensaje);
   			$nextAction = $form->get('guardarynuevo')->isClicked()
   				? 'alta_pais'
   				: 'resultado_operacion';
   			return $this->redirect($this->generateUrl($nextAction));
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar un pais en el sistema';
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion'));
   		}
    }
}