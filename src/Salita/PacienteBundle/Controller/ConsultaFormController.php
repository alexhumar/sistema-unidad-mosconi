<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\ConsultaType;
use Salita\PacienteBundle\Entity\Consulta;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class ConsultaFormController extends MyController
{
	
    /*Alta de consulta (fase GET)*/
 /*   public function newAction()
    {
       $session = $this->getSession();
       if (!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {
           if (!$session->has('diagnosticoSeleccionado'))
           {
                return $this->redirect($this->generateUrl('busqueda_diagnostico'));
           }
           else
           {
                $consulta = new Consulta();
                $form = $this->createForm(new ConsultaType(), $consulta);
                return $this->render(
                			'SalitaPacienteBundle:ConsultaForm:new.html.twig',
                   			array('form' => $form->createView())
                   		);
           }
       }
    } */
    
    /*Alta de consulta*/
    public function newAction()
    {
    	$session = $this->getSession();
    	if (!$session->has('paciente'))
    	{
    		return $this->redirect($this->generateUrl('busqueda_paciente'));
    	}
    	if (!$session->has('diagnosticoSeleccionado'))
    	{
    		return $this->redirect($this->generateUrl('busqueda_diagnostico'));
    	}
    	$consulta = new Consulta();
    	$form = $this->createForm(new ConsultaType(), $consulta);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$paciente = $session->get('paciente');
   			$usuario = $session->get('usuario');
   			$diagnostico = $session->get('diagnosticoSeleccionado');
   			$this->getPersistenceManager()->saveConsulta($consulta, $paciente, $usuario, $diagnostico);
   			$session->remove('diagnosticoSeleccionado');
   			$mensaje = "La consulta fue ingresada exitosamente";
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion_paciente'));
   			//return $this->redirect($this->generateUrl('menu_paciente'));
   		}
   		return $this->render(
					'SalitaPacienteBundle:ConsultaForm:new.html.twig',
					array('form' => $form->createView())
				);
   	}
}