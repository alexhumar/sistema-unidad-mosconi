<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\BusquedaType;
use Salita\OtrosBundle\Clases\Busqueda;
use Salita\OtrosBundle\Form\Type\BusquedaDiagnosticoType;
use Salita\OtrosBundle\Clases\BusquedaDiagnostico;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class BusquedaController extends MyController
{

	/*Busqueda de vacuna (fase GET)*/
    public function buscarAction()
    {
        $session = $this->getSession();
        $busqueda = new Busqueda();
        $form = $this->createForm(new BusquedaType(), $busqueda);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaOtrosBundle:Busqueda:ingresoDatos.html.twig',
           			array('form' => $form->createView()/*,'rol' => $rolSeleccionado->getCodigo(),
           				  'nombreRol' => $rolSeleccionado->getNombre()*/)
           		);
    }
    
    /*Busqueda de vacuna (fase POST)*/
    public function buscarProcessAction()
    {
    	$session = $this->getSession();
    	$busqueda = new Busqueda();
    	$form = $this->createForm(new BusquedaType(), $busqueda);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$repoVacunas = $this->getReposManager()->getVacunasRepo();
   			$vacunas = $repoVacunas->buscarVacuna($busqueda->getPalabra());
   			return $this->render(
   					'SalitaOtrosBundle:Busqueda:resultado.html.twig',
   					array('vacunas' => $vacunas,'rol' => $rolSeleccionado->getCodigo(),
   							'nombreRol' => $rolSeleccionado->getNombre())
   			);
   		}
    }
    
    /*Busqueda de diagnostico (fase GET)*/
    public function buscarDiagnosticoAction()
    {
        $session = $this->getSession();
        $busqueda = new BusquedaDiagnostico();
        $form = $this->createForm(new BusquedaDiagnosticoType(), $busqueda);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaOtrosBundle:BusquedaDiagnostico:ingresoDatos.html.twig',
           			array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),
           				  'nombreRol' => $rolSeleccionado->getNombre())
           		);
    }
    
    /*Busqueda de diagnostico (fase POST)*/
    public function buscarDiagnosticoProcessAction()
    {
    	$session = $this->getSession();
    	$busqueda = new BusquedaDiagnostico();
    	$form = $this->createForm(new BusquedaDiagnosticoType(), $busqueda);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$repoDiagnosticos = $this->getReposManager()->getDiagnosticosRepo();
   			$diagnosticos = $repoDiagnosticos->buscarDiagnostico($busqueda->getPalabra());
   			return $this->render(
   					'SalitaOtrosBundle:BusquedaDiagnostico:resultado.html.twig',
   					array('diagnosticos' => $diagnosticos,'rol' => $rolSeleccionado->getCodigo(),
   							'nombreRol' => $rolSeleccionado->getNombre())
   			);
   		}
    }
}