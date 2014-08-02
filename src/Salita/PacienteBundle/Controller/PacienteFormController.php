<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\DatosFiliatoriosModificacionType;
use Salita\PacienteBundle\Form\Type\DatosFiliatoriosRegistroType;
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
    	$form = $this->createForm(new DatosFiliatoriosModificacionType(), $paciente);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$em = $this->getEntityManager();
   			$em->flush();
   			/* Actualiza el paciente guardado en la sesion */
   			$session->set('paciente', $paciente);
   			$translator = $this->getTranslator();
   			$mensaje = $this->getDialogsManager()->modificacionDatosPacienteExitoMsg();
   			$session->set('mensaje', $translator->trans($mensaje));
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
    	$form = $this->createForm(new DatosFiliatoriosRegistroType(), $paciente);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->savePaciente($paciente);
   			$session = $this->getSession();
   			$translator = $this->getTranslator();
   			$mensaje = $this->getDialogsManager()->cargaPacienteExitoMsg();
   			$session->set('mensaje', $translator->trans($mensaje));
   			return $this->redirect($this->generateUrl('resultado_operacion'));
   		}
   		return $this->render(
           			'SalitaPacienteBundle:PacienteForm:new.html.twig', 
           			array('form' => $form->createView())
           		);
    }
}