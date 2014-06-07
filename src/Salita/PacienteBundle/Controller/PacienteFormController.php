<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\DatosFiliatoriosType;
use Salita\PacienteBundle\Entity\Paciente;
use Salita\PacienteBundle\Entity\AntecedentePersonalClinico;
use Salita\PacienteBundle\Entity\AntecedentePersonalObstetrico;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarClinico;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarObstetrico;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class PacienteFormController extends Controller
{
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function getPacientesRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:Paciente');
	}
	
	private function guardarPaciente($paciente)
	{
		$antecedentePersonalObstetrico = new AntecedentePersonalObstetrico();
		$antecedentePersonalObstetrico->setPaciente($paciente);
		$antecedenteFamiliarObstetrico = new AntecedenteFamiliarObstetrico();
		$antecedenteFamiliarObstetrico->setPaciente($paciente);
		$antecedentePersonalClinico = new AntecedentePersonalClinico();
		$antecedentePersonalClinico->setPaciente($paciente);
		$antecedenteFamiliarClinico = new AntecedenteFamiliarClinico();
		$antecedenteFamiliarClinico->setPaciente($paciente);
		$em = $this->getEntityManager();
		$em->persist($paciente);
		$em->flush();
	}

	/*Modificacion de datos filiatorios (fase GET)*/
    public function modificarDatosFiliatoriosAction(Request $request)
    {
        $session = $request->getSession();
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
    public function modificarDatosFiliatoriosProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	$paciente = $session->get('paciente');
    	//Esto lo agregue el 07/06/2014--Aunque hay que ver si es necesario ya que el paciente de
    	//la sesion proviene de una consulta al repo de pacientes con un find($id).
    	//Quizas ya este "vigilado" por Doctrine... cuestion de probar...
    	$repoPacientes = $this->getPacientesRepo();
    	$paciente = $repoPacientes->find($paciente->getId());
    	//
    	$form = $this->createForm(new DatosFiliatoriosType(), $paciente);
   		$form->handleRequest($request);
   		$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
   		if ($form->isValid())
   		{
   			$em = $this->getEntityManager();
   			//$em->persist($paciente);
   			$em->flush();
   			$mensaje = 'La modificacion del paciente se realizó con exito';
   			return $this->render(
   					'SalitaPacienteBundle:PacienteForm:mensajeModificacion.html.twig',
   					array('mensaje' => $mensaje,'rol' =>$rolSeleccionado->getCodigo(),
   							'nombreRol' =>$rolSeleccionado->getNombre())
   			);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar modificar los datos del paciente';
   			return $this->render(
   					'SalitaPacienteBundle:PacienteForm:mensajeModificacion.html.twig',
   					array('mensaje' => $mensaje,'rol' =>$rolSeleccionado->getCodigo(),
   							'nombreRol' =>$rolSeleccionado->getNombre())
   			);
   		}
    }
    
    /*Alta de paciente (fase GET)*/
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $paciente = new Paciente();
        $form = $this->createForm(new DatosFiliatoriosType(), $paciente);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaPacienteBundle:PacienteForm:new.html.twig', 
           			array('form' => $form->createView(), 'rol' => $rolSeleccionado->getCodigo())
           		);
    }
    
    /*Alta de paciente (fase POST)*/
    public function newProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	$paciente = new Paciente();
    	$form = $this->createForm(new DatosFiliatoriosType(), $paciente);
   		$form->handleRequest($request);
   		$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
   		if ($form->isValid())
   		{
   			$this->guardarPaciente($paciente);
   			$mensaje = 'El paciente se cargo exitosamente en el sistema';
   			return $this->render(
   					'SalitaPacienteBundle:PacienteForm:mensajeAlta.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
   			);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar el paciente al sistema';
   			return $this->render(
   					'SalitaPacienteBundle:PacienteForm:mensajeAlta.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
   			);
   		}
    }
}
