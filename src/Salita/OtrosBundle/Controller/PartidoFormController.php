<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\PartidoType;
use Salita\OtrosBundle\Entity\Partido;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PartidoFormController extends Controller
{
	/*ATENCION: ninguno de los controladores de esta clase tiene rutas asociadas.*/
	
	/*Alta de partido (fase GET)*/
    public function newAction(Request $request)
    {
        $partido = new Partido();
        $form = $this->createForm(new PartidoType(), $partido);
        return $this->render(
           			'SalitaOtrosBundle:PartidoForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    /*Alta de partido (fase POST)*/
    public function newProcessAction(Request $request)
    {
    	$partido = new Partido();
    	$form = $this->createForm(new PartidoType(), $partido);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->get('persistence_manager')->savePartido($partido);
   			$mensaje = 'El partido se cargo exitosamente en el sistema';
   			return $this->render(
   						'SalitaOtrosBundle:PartidoForm:mensaje.html.twig',
   						array('mensaje' => $mensaje)
   					);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar un partido en el sistema';
   			return $this->render(
   						'SalitaOtrosBundle:PartidoForm:mensaje.html.twig',
   						array('mensaje' => $mensaje)
   					);
   		}
    }
      
    function listAction(Request $request)
    {
        $repoPartidos = $this->get('repos_manager')->getPartidosRepo();
        $partidos = $repoPartidos->encontrarTodosOrdenadosPorNombre();
        return $this->render(
        			'SalitaOtrosBundle:PartidoForm:listado.html.twig',
        			array('partidos' => $partidos)
        		);
    }
    
    /*Modificacion de partido (fase GET)*/
    public function modifAction(Request $request, $id)
    {
        $repoPartidos = $this->get('repos_manager')->getPartidosRepo();
        $partido = $repoPartidos->find($id);
        if(!$partido)
        {
        	throw $this->createNotFoundException("Partido inexistente");
        }
        $form = $this->createForm(new PartidoType(), $partido);
        return $this->render(
           			'SalitaOtrosBundle:PartidoForm:modif.html.twig',
           			array('form' => $form->createView(),'id' => $id)
           		);
    }
    
    /*Modificacion de partido (fase POST)*/
    public function modifProcessAction(Request $request, $id)
    {
    	$repoPartidos = $this->get('repos_manager')->getPartidosRepo();
    	$partido = $repoPartidos->find($id);
    	if(!$partido)
    	{
    		throw $this->createNotFoundException("Partido inexistente");
    	}
    	$form = $this->createForm(new PartidoType(), $partido);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->get('persistence_manager')->updatePartido($partido);
   			$mensaje = 'El partido fue modificado exitosamente';
   			return $this->render(
   					'SalitaOtrosBundle:PartidoForm:mensaje.html.twig',
   					array('mensaje' => $mensaje)
   			);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar modificar el partido seleccionado';
   			return $this->render(
   					'SalitaOtrosBundle:PartidoForm:mensaje.html.twig',
   					array('mensaje' => $mensaje)
   			);
   		}
    }
}
