<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\EstudioType;
use Salita\PacienteBundle\Entity\Estudio;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class EstudioFormController extends Controller
{
	
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function guardarEstudio($estudio, $paciente, $usuario)
	{
		$estudio->setPaciente($paciente);
		$estudio->setUsuario($usuario);
		$estudio->setFecha(date("d-m-Y"));
		$estudio->setHora(date("H:i:s"));
		$em = $this->getEntityManager();
		$em->persist($estudio);
		$em->flush();
	}

	/*Alta de estudio (fase GET)*/
    public function newAction(Request $request)
    {
        $session = $request->getSession();
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
    public function newProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	$estudio = new Estudio();
    	$form = $this->createForm(new EstudioType(), $estudio);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$paciente = $session->get('paciente');
   			$usuario = $session->get('usuario');
   			$this->guardarEstudio($estudio, $paciente, $usuario);
   			$mensaje = 'El estudio del paciente se cargo exitosamente en el sistema';
   			return $this->render(
   					'SalitaPacienteBundle:EstudioForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
   							'nombreRol' => $rolSeleccionado->getNombre())
   			);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar un estudio para el paciente';
   			return $this->render(
   					'SalitaPacienteBundle:EstudioForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
   							'nombreRol' => $rolSeleccionado->getNombre())
   			);
   		}
    }
}
