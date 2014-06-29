<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\EstudioType;
use Salita\PacienteBundle\Entity\Estudio;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class EstudioFormController extends MyController
{
	
	/*Alta de estudio (fase GET)*/
    public function newAction()
    {
        $estudio = new Estudio();
        $form = $this->createForm(new EstudioType(), $estudio);
        return $this->render(
           			'SalitaPacienteBundle:EstudioForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    /*Alta de estudio (fase POST)*/
    public function newProcessAction()
    {
    	$estudio = new Estudio();
    	$form = $this->createForm(new EstudioType(), $estudio);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$session = $this->getSession();
   			$paciente = $session->get('paciente');
   			$usuario = $session->get('usuario');
   			$this->getPersistenceManager()->saveEstudio($estudio, $paciente, $usuario);
   			$mensaje = 'El estudio del paciente se cargo exitosamente en el sistema';
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar un estudio para el paciente';
   		}
   		return $this->render(
   				'SalitaPacienteBundle:EstudioForm:mensaje.html.twig',
   				array('mensaje' => $mensaje)
   		);
    }
}