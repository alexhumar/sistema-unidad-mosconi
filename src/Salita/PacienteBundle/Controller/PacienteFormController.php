<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\DatosFiliatoriosType;
use Salita\PacienteBundle\Entity\Paciente;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class PacienteFormController extends MyController
{

	/*Modificacion de datos filiatorios (fase GET)*/
    public function modificarDatosFiliatoriosAction()
    {
        $session = $this->getSession();
        $paciente = $session->get('paciente');
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $form = $this->createForm(new DatosFiliatoriosType(), $paciente);
        return $this->render(
 	      			'SalitaPacienteBundle:PacienteForm:datosFiliatorios.html.twig', 
    	   			array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(), 
       				      'nombreRol' => $rolSeleccionado->getNombre())
           		);
    }
    
    /*Modificacion de datos filiatorios (fase POST)*/
    public function modificarDatosFiliatoriosProcessAction()
    {
    	$session = $this->getSession();
    	$paciente = $session->get('paciente');
    	$repoPacientes = $this->getReposManager()->getPacientesRepo();
    	$paciente = $repoPacientes->find($paciente->getId());
    	$form = $this->createForm(new DatosFiliatoriosType(), $paciente);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
   		if ($form->isValid())
   		{
   			$em = $this->getEntityManager();
   			//$em->persist($paciente);
   			$em->flush();
   			$mensaje = 'La modificacion de los datos del paciente se realizó con exito';
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar modificar los datos del paciente';
   		}
   		return $this->render(
   					'SalitaPacienteBundle:PacienteForm:mensajeModificacion.html.twig',
   					array('mensaje' => $mensaje,'rol' =>$rolSeleccionado->getCodigo(),
   						  'nombreRol' =>$rolSeleccionado->getNombre())
   				);
    }
    
    /*Alta de paciente (fase GET)*/
    public function newAction()
    {
        $session = $this->getSession();
        $paciente = new Paciente();
        $form = $this->createForm(new DatosFiliatoriosType(), $paciente);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaPacienteBundle:PacienteForm:new.html.twig', 
           			array('form' => $form->createView(), 'rol' => $rolSeleccionado->getCodigo())
           		);
    }
    
    /*Alta de paciente (fase POST)*/
    public function newProcessAction()
    {
    	$session = $this->getSession();
    	$paciente = new Paciente();
    	$form = $this->createForm(new DatosFiliatoriosType(), $paciente);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->savePaciente($paciente);
   			$mensaje = 'El paciente se cargo exitosamente en el sistema';
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar el paciente al sistema';
   		}
   		return $this->render(
   				'SalitaPacienteBundle:PacienteForm:mensajeAlta.html.twig',
   				array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
   		);
    }
}