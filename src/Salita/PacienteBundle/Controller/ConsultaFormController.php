<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\ConsultaType;
use Salita\PacienteBundle\Entity\Consulta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class ConsultaFormController extends Controller
{
	
	private function getEntityManager()
	{
		return $this->getDoctrine->getManager();
	}
	
	private function guardarConsulta($consulta, $paciente, $usuario, $diagnostico)
	{
		$consulta->setPaciente($paciente);
		$consulta->setUsuario($usuario);
		$consulta->setDiagnostico($diagnostico);
		$consulta->setFecha(date("d-m-Y"));
		$consulta->setHora(date("H:i:s"));
		$em = $this->getEntityManager();
		$em->persist($consulta);
		$em->flush();
	}
	
    /*Alta de consulta (fase GET)*/
    public function newAction(Request $request)
    {
       $session = $request->getSession();
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
                $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
                return $this->render(
                			'SalitaPacienteBundle:ConsultaForm:new.html.twig',
                   			array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),
                   				  'nombreRol' => $rolSeleccionado->getNombre())
                   		);
           }
       }
    }
    
    /*Alta de consulta (fase POST)*/
    public function newProcessAction(Request $request)
    {
    	$session = $request->getSession();
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
   				$form->handleRequest($request);
   				if ($form->isValid())
   				{
   					$paciente = $session->get('paciente');
   					$usuario = $session->get('usuario');
   					$diagnostico = $session->get('diagnosticoSeleccionado');
   					$this->guardarConsulta($consulta, $paciente, $usuario, $diagnostico);
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
