<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\BusquedaType;
use Salita\PacienteBundle\Clases\Busqueda;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class BusquedaController extends MyController
{
	
	/*Busqueda de paciente (fase GET)*/
    public function buscarAction()
    {
        $busqueda = new Busqueda();
        $form = $this->createForm(new BusquedaType(), $busqueda);
        return $this->render(
           			'SalitaPacienteBundle:Busqueda:ingresoDatos.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    /*Busqueda de paciente (fase POST)*/
    public function buscarProcessAction()
    { 	
    	$busqueda = new Busqueda();
    	$form = $this->createForm(new BusquedaType(), $busqueda);
    	$request = $this->getRequest();
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$repoPacientes = $this->getReposManager()->getPacientesRepo();
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
    		return $this->render(
    				'SalitaPacienteBundle:Busqueda:resultado.html.twig',
    				array('pacientes' => $pacientes)
    		);
    	}
    }
}