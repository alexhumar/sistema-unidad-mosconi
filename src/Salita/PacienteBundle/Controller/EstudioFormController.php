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
        $session = $this->getSession();
        $estudio = new Estudio();
        $form = $this->createForm(new EstudioType(), $estudio);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaPacienteBundle:EstudioForm:new.html.twig',
           			array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),
           				  'nombreRol' => $rolSeleccionado->getNombre())
           		);
    }
    
    /*Alta de estudio (fase POST)*/
    public function newProcessAction()
    {
    	$session = $this->getSession();
    	$estudio = new Estudio();
    	$form = $this->createForm(new EstudioType(), $estudio);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
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
   				array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
   						'nombreRol' => $rolSeleccionado->getNombre())
   		);
    }
}