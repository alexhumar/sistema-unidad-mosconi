<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\ConsultaType;
use Salita\PacienteBundle\Entity\Consulta;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class ConsultaFormController extends MyController
{
	
    /*Alta de consulta (fase GET)*/
    public function newAction()
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
    }
    
    /*Alta de consulta (fase POST)*/
    public function newProcessAction()
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
    			$request = $this->getRequest();
   				$form->handleRequest($request);
   				if ($form->isValid())
   				{
   					$paciente = $session->get('paciente');
   					$usuario = $session->get('usuario');
   					$diagnostico = $session->get('diagnosticoSeleccionado');
   					$this->getPersistenceManager()->saveConsulta($consulta, $paciente, $usuario, $diagnostico);
   					$session->remove('diagnosticoSeleccionado');
   					return $this->redirect($this->generateUrl('menu_paciente'));
   				}
   				else
   				{
   					$mensaje = 'Se produjo un error al cargar la consulta en el sistema';
   					return $this->render(
   								'SalitaPacienteBundle:ConsultaForm:mensaje.html.twig',
   								array('mensaje' => $mensaje)
   							);
   				}
    		}
    	}
    }
}