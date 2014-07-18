<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\DatosFiliatoriosType;
use Salita\PacienteBundle\Entity\Paciente;
use Salita\OtrosBundle\Clases\MyController;

class PacienteFormController extends MyController
{
    
    /*Modificacion de datos filiatorios*/
    public function modificarDatosFiliatoriosAction()
    {
    	$session = $this->getSession();
    	$paciente = $session->get('paciente');
    	$repoPacientes = $this->getReposManager()->getPacientesRepo();
    	$paciente = $repoPacientes->find($paciente->getId());
    	$form = $this->createForm(new DatosFiliatoriosType(), $paciente);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$em = $this->getEntityManager();
   			$em->flush();
   			/* Actualiza el paciente guardado en la sesion */
   			$session->set('paciente', $paciente);
   			$mensaje = 'La modificacion de los datos del paciente se realizó con exito';
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion_paciente'));
   		}
   		return $this->render(
   				'SalitaPacienteBundle:PacienteForm:datosFiliatorios.html.twig',
   				array('form' => $form->createView())
   		);
    }
    
    /*Alta de paciente*/
    public function newAction()
    {
    	$paciente = new Paciente();
    	$form = $this->createForm(new DatosFiliatoriosType(), $paciente);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->savePaciente($paciente);
   			$mensaje = 'El paciente se cargo exitosamente en el sistema';
   			$session = $this->getSession();
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion'));
   		}
   		return $this->render(
           			'SalitaPacienteBundle:PacienteForm:new.html.twig', 
           			array('form' => $form->createView())
           		);
    }
}