<?php
namespace Salita\TurnoBundle\Controller;

use Salita\TurnoBundle\Form\Type\TurnoType;
use Salita\TurnoBundle\Entity\Turno;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\FechaYHoraTurno;
use Salita\PacienteBundle\Form\Type\FechaYHoraTurnoType;

class TurnoController extends MyController
{
    
    /*Alta de turno*/
    public function newAction()
    { 	
    	$turno = new Turno();
    	$request = $this->getRequest();
    	$form = $this->createForm(new TurnoType(), $turno);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$session = $this->getSession();
    		$paciente = $session->get('paciente');
    		$medico = $session->get('usuario');
    		/*Da de alta un turno del momento*/
			$this->getPersistenceManager()->saveNowTurno($turno, $medico, $paciente);
    		$mensaje = 'El turno para el paciente se agrego exitosamente';
    		$session->set('mensaje', $mensaje);
    		return $this->redirect($this->generateUrl('resultado_operacion_turno'));
    	}
    	return $this->render(
        			'SalitaTurnoBundle:TurnoForm:new.html.twig',
        			array('form' => $form->createView())
           		);
    }
    
    /*Alta de turno futuro*/
    public function newFuturoAction()
    {
    	$session = $this->getSession();
    	if((!$session->has('fecha')) and (!$session->has('hora')))
    	{
    		return $this->redirect($this->generateUrl('seleccion_fecHor_futuro'));
    	}
    	$turno = new Turno();
    	$form = $this->createForm(new TurnoType(),$turno);
    	$request = $this->getRequest();
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$paciente = $session->get('paciente');
    		$medico = $session->get('usuario');
    		$this->getPersistenceManager()->saveTurno($turno, $medico, $paciente, $session->get('fecha'), $session->get('hora'));
    		$session->remove('fecha');
    		$session->remove('hora'); 		
    		$mensaje = 'El turno para el paciente se agrego exitosamente';
    		$session->set('mensaje', $mensaje);
    		return $this->redirect($this->generateUrl('resultado_operacion_turno'));
    		
    	}
    	return $this->render(
    				'SalitaTurnoBundle:TurnoForm:newConFecHor.html.twig',
    				array('form' => $form->createView())
    			);
    }
    
    /*Seleccionar fecha y hora para un turno*/
    public function seleccionarFecHorAction()
    {
    	$session = $this->getSession();
    	if(!$session->has('paciente'))
    	{
    		return $this->redirect($this->generateUrl('busqueda_paciente'));
    	}
   		$fecHor = new FechaYHoraTurno();
   		$form = $this->createForm(new FechaYHoraTurnoType(), $fecHor);
   		$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$session->set('fecha', $fecHor->getFecha());
   			$session->set('hora', $fecHor->getHoraCompleta());
   			return $this->redirect($this->generateUrl('alta_turno_futuro'));
   		}
   		return $this->render(
           			'SalitaTurnoBundle:SeleccionFechaHora:ingresoDatos.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    public function atencionAction($idTurno)
    {
    	/*Aca le paso el controller para poder tirar la excepcion (ver metodo), pero no me parece lo mas
    	 * correcto hacer eso... revisar*/
    	$this->getPersistenceManager()->setTurnoAtendido($idTurno, $this);
    	/*$session = $this->getSession();
    	$usuario = $session->get('usuario');
    	if ($usuario->isMedico())
    	{
    		$nextAction = "listado_turnos_especialidad";
    	}
    	else
    	{
    		$nextAction = "listado_turnos";
    	}*/
    	//$nextAction = $this->getRequest()->
        //return $this->redirect($this->generateUrl($nextAction));
        return $this->redirect($this->getRequest()->getReferer());
    }
}