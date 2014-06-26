<?php
namespace Salita\TurnoBundle\Controller;

use Salita\TurnoBundle\Form\Type\TurnoType;
use Salita\TurnoBundle\Entity\Turno;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\FechaYHoraTurno;
use Salita\PacienteBundle\Form\Type\FechaYHoraTurnoType;
use Salita\OtrosBundle\Clases\ConsultaRol;

class TurnoController extends MyController
{

	/*Alta de turno (fase GET)*/
    public function newAction()
    {
        $session = $this->getSession();
        $turno = new Turno();
        $form = $this->createForm(new TurnoType(), $turno);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
        		'SalitaTurnoBundle:TurnoForm:new.html.twig',
        		array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),
        	          'nombreRol' => $rolSeleccionado->getNombre())
           		);
    }
    
    /*Alta de turno (fase POST)*/
    public function newProcessAction()
    { 	
    	$session = $this->getSession();
    	$turno = new Turno();
    	$request = $this->getRequest();
    	$form = $this->createForm(new TurnoType(), $turno);
    	$form->handleRequest($request);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	if ($form->isValid())
    	{
    		$paciente = $session->get('paciente');
    		$medico = $session->get('usuario');
    		/*Da de alta un turno del momento*/
			$this->getPersistenceManager()->saveNowTurno($turno, $medico, $paciente);
    		$mensaje = 'El turno para el paciente se agrego exitosamente';
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al intentar agregar un turno para el paciente';
    	}
    	return $this->render(
    			'SalitaTurnoBundle:TurnoForm:mensaje.html.twig',
    			array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    					'nombreRol' => $rolSeleccionado->getNombre())
    	);
    }
    
    /*Alta de turno futuro (fase GET)*/
    public function newFuturoAction()
    {
    	$session = $this->getSession();
    	if((!$session->has('fecha')) and (!$session->has('hora')))
    	{
    		return $this->redirect($this->generateUrl('seleccion_fecHor_futuro'));
    	}
    	$turno = new Turno();
    	$form = $this->createForm(new TurnoType(),$turno);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	return $this->render(
    					'SalitaTurnoBundle:TurnoForm:newConFecHor.html.twig',
    					array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),
    						  'nombreRol' => $rolSeleccionado->getNombre())
    			);
    }
    
    /*Alta de turno futuro (fase POST)*/
    public function newFuturoProcessAction()
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
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	if ($form->isValid())
    	{
    		$paciente = $session->get('paciente');
    		$medico = $session->get('usuario');
    		$this->getPersistenceManager()->saveTurno($turno, $medico, $paciente, $session->get('fecha'), $session->get('hora'));
    		$session->remove('fecha');
    		$session->remove('hora'); 		
    		$mensaje = 'El turno para el paciente se agrego exitosamente';
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al intentar agregar un turno para el paciente';
    	}
    	return $this->render(
    			'SalitaTurnoBundle:TurnoForm:mensaje.html.twig',
    			array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    					'nombreRol' => $rolSeleccionado->getNombre())
    	);
    }

    /*Seleccionar fecha y hora para un turno (fase GET)*/
    public function seleccionarFecHorAction()
    {
       $session = $this->getSession();
       if(!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {            
           $fecHor = new FechaYHoraTurno();
           $form = $this->createForm(new FechaYHoraTurnoType(), $fecHor);
           $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
           return $this->render(
           				'SalitaTurnoBundle:SeleccionFechaHora:ingresoDatos.html.twig',
           				array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(), 
           					  'nombreRol' => $rolSeleccionado->getNombre())
           			);
       }
    }
    
    /*Seleccionar fecha y hora para un turno (fase POST)*/
    public function seleccionarFecHorProcessAction()
    {
    	$session = $this->getSession();
    	if(!$session->has('paciente'))
    	{
    		return $this->redirect($this->generateUrl('busqueda_paciente'));
    	}
    	else
    	{
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
    		/*Agregado el 03/06/2014. Al dia de la fecha NO FUE PROBADO*/
    		else 
    		{
    			$mensaje = 'Se produjo un error al las fechas para un turno';
    			$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    			return $this->render(
    					'SalitaTurnoBundle:TurnoForm:mensaje.html.twig',
    					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    							'nombreRol' => $rolSeleccionado->getNombre())
    			);
    		}
    	}
    }
    
    public function atencionAction($idTurno)
    {
    	/*Aca le paso el controller para poder tirar la excepcion (ver metodo), pero no me parece lo mas
    	 * correcto hacer eso... revisar*/
    	$this->getPersistenceManager()->setTurnoAtendido($idTurno, $this);
        //$session = $this->getSession();
        /*Esto ni idea por que lo hice... atento con eso...*/
        //$session->set('paciente', $turno->getPaciente());
        return $this->redirect($this->generateUrl('menu_paciente'));   
    }
}