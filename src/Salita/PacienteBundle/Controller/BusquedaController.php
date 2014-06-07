<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\BusquedaType;
use Salita\PacienteBundle\Clases\Busqueda;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class BusquedaController extends Controller
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
    
	/*Busqueda de paciente (fase GET)*/
    public function buscarAction(Request $request)
    {
        $session = $request->getSession();
        $busqueda= new Busqueda();
        $form = $this->createForm(new BusquedaType(), $busqueda);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaPacienteBundle:Busqueda:ingresoDatos.html.twig',
           			array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(), 
           				  'nombreRol' => $rolSeleccionado->getNombre())
           		);
    }
    
    /*Busqueda de paciente (fase POST)*/
    public function buscarProcessAction(Request $request)
    { 	
    	$busqueda = new Busqueda();
    	$form = $this->createForm(new BusquedaType(), $busqueda);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$repoPacientes = $this->getPacientesRepo();
    		switch ($busqueda->getCriterio())
    		{
    			case 'DNI':
    				$pacientes = $repoPacientes->buscarPorDNI($busqueda->getPalabra());
    				break;
    			case 'Apellido':
    				$pacientes = $repoPacientes->buscarPorApellido($busqueda->getPalabra());
    				break;
    			case 'Nombre':
    				$pacientes = $repoPacientes->buscarPorNombre($busqueda->getPalabra());
    				break;
    		}
    		$session = $request->getSession();
    		$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    		return $this->render(
    				'SalitaPacienteBundle:Busqueda:resultado.html.twig',
    				array('pacientes' => $pacientes,'rol' => $rolSeleccionado->getCodigo(),
    						'nombreRol' => $rolSeleccionado->getNombre())
    		);
    	}
    }
}
