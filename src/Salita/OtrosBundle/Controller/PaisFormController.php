<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\PaisType;
use Salita\OtrosBundle\Entity\Pais;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PaisFormController extends Controller
{
	/*ATENCION: NO HAY RUTA QUE REFERENCIE ESTE CONTROLADOR.*/
	
	/*Alta de pais (fase GET)*/
    public function newAction(Request $request)
    {
        $pais = new Pais();
        $form = $this->createForm(new PaisType(), $pais);
        return $this->render(
           			'SalitaOtrosBundle:PaisForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    /*Alta de pais (fase POST)*/
    public function newProcessAction(Request $request)
    {
    	$pais = new Pais();
    	$form = $this->createForm(new PaisType(), $pais);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->get('persistence_manager')->savePais($pais);
   			$mensaje = 'El pais se cargo exitosamente en el sistema';
   			return $this->render(
   					'SalitaOtrosBundle:PaisForm:mensaje.html.twig',
   					array('mensaje' => $mensaje)
   			);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar un pais en el sistema';
   			return $this->render(
   					'SalitaOtrosBundle:PaisForm:mensaje.html.twig',
   					array('mensaje' => $mensaje)
   			);
   		}
    }
}
