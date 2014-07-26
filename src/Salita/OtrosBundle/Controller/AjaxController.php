<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\BusquedaType;
use Salita\OtrosBundle\Clases\Busqueda;
use Salita\OtrosBundle\Form\Type\BusquedaDiagnosticoType;
use Salita\OtrosBundle\Clases\BusquedaDiagnostico;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

use Symfony\Component\HttpFoundation\Response;

class AjaxController extends MyController
{

    public function localidadesDePartidoAction()
    {
    	$repoLocalidades = $this->getReposManager()->getLocalidadesRepo();
    	$idPartido = $this->getRequest()->query->get('data');
    	$localidades = $repoLocalidades->localidadesDePartido($idPartido);
    	return $this->render(
	           		'SalitaOtrosBundle:Ajax:localidadesDePartido.html.twig',
    			    array('localidades' => $localidades)
    			);
    }
    
    public function barriosDeLocalidadAction()
    {
    	$repoBarrios = $this->getReposManager()->getBarriosRepo();
    	$idLocalidad = $this->getRequest()->query->get('data');
    	$barrios = $repoBarrios->barriosDeLocalidad($idLocalidad);
    	return $this->render(
    			'SalitaOtrosBundle:Ajax:barriosDeLocalidad.html.twig',
    			array('barrios' => $barrios)
    	);
    }
}