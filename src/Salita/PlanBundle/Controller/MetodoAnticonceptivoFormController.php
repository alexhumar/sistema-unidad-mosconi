<?php
namespace Salita\PlanBundle\Controller;

use Salita\PlanBundle\Form\Type\MetodoAnticonceptivoType;
use Salita\PlanBundle\Entity\MetodoAnticonceptivo;
use Salita\OtrosBundle\Clases\MyController;

class MetodoAnticonceptivoFormController extends MyController
{
    
    /*Alta de metodo anticonceptivo*/
    public function newAction()
    {
    	$metodo = new MetodoAnticonceptivo();
    	$form = $this->createForm(new MetodoAnticonceptivoType(), $metodo);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->saveMetodoAnticonceptivo($metodo);
   			$mensaje = 'El metodo anticonceptivo se cargo exitosamente en el sistema';
   			$session = $this->getSession();
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion'));
   		}
   		return $this->render(
           			'SalitaPlanBundle:MetodoAnticonceptivoForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
}