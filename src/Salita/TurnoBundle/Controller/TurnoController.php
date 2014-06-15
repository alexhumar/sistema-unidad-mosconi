<?php
namespace Salita\TurnoBundle\Controller;

use Salita\TurnoBundle\Form\Type\TurnoType;
use Salita\TurnoBundle\Entity\Turno;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\FechaYHoraTurno;
use Salita\PacienteBundle\Form\Type\FechaYHoraTurnoType;
use Salita\OtrosBundle\Clases\ConsultaRol;

class TurnoController extends Controller
{

	/*Alta de turno (fase GET)*/
    public function newAction(Request $request)
    {
        $session = $request->getSession();
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
    public function newProcessAction(Request $request)
    { 	
    	$session = $request->getSession();
    	$turno = new Turno();
    	$form = $this->createForm(new TurnoType(), $turno);
    	$form->handleRequest($request);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	if ($form->isValid())
    	{
    		$paciente = $session->get('paciente');
    		$medico = $session->get('usuario');
    		/*Da de alta un turno del momento*/
			$this->get('persistence_manager')->saveNowTurno($turno, $medico, $paciente);
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
    public function newFuturoAction(Request $request)
    {
    	$session = $request->getSession();
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
    public function newFuturoProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	if((!$session->has('fecha')) and (!$session->has('hora')))
    	{
    		return $this->redirect($this->generateUrl('seleccion_fecHor_futuro'));
    	}
    	$turno = new Turno();
    	$form = $this->createForm(new TurnoType(),$turno);
    	$form->handleRequest($request);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	if ($form->isValid())
    	{
    		$paciente = $session->get('paciente');
    		$medico = $session->get('usuario');
    		$this->get('persistence_manager')->saveTurno($turno, $medico, $paciente, $session->get('fecha'), $session->get('hora'));
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
    public function seleccionarFecHorAction(Request $request)
    {
       $session = $request->getSession();
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
    public function seleccionarFecHorProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	if(!$session->has('paciente'))
    	{
    		return $this->redirect($this->generateUrl('busqueda_paciente'));
    	}
    	else
    	{
    		$fecHor = new FechaYHoraTurno();
    		$form = $this->createForm(new FechaYHoraTurnoType(), $fecHor);
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
    
    public function atencionAction(Request $request, $idTurno)
    {
    	/*Aca le paso el controller para poder tirar la excepcion (ver metodo), pero no me parece lo mas
    	 * correcto hacer eso... revisar*/
    	$this->get('persistence_manager')->setTurnoAtendido($idTurno, $this);
        //$session = $request->getSession();
        /*Esto ni idea por que lo hice... atento con eso...*/
        //$session->set('paciente', $turno->getPaciente());
        return $this->redirect($this->generateUrl('menu_paciente'));   
    }
}