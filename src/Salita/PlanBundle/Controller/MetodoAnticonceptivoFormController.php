<?php
namespace Salita\PlanBundle\Controller;

use Salita\PlanBundle\Form\Type\MetodoAnticonceptivoType;
use Salita\PlanBundle\Entity\MetodoAnticonceptivo;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class MetodoAnticonceptivoFormController extends MyController
{

	/*Alta de metodo anticonceptivo (fase GET)*/
    public function newAction()
    {
        $metodo = new MetodoAnticonceptivo();
        $form = $this->createForm(new MetodoAnticonceptivoType(), $metodo);
        return $this->render(
           			'SalitaPlanBundle:MetodoAnticonceptivoForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    /*Alta de metodo anticonceptivo (fase POST)*/
    public function newProcessAction()
    {
    	$metodo = new MetodoAnticonceptivo();
    	$form = $this->createForm(new MetodoAnticonceptivoType(), $metodo);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->saveMetodoAnticonceptivo($metodo);
   			$mensaje = 'El metodo anticonceptivo se cargo exitosamente en el sistema';
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar el metodo anticonceptivo al sistema';
   		}
   		return $this->render(
   				'SalitaPlanBundle:MetodoAnticonceptivoForm:mensaje.html.twig',
   				array('mensaje' => $mensaje)
   		);
    }
}