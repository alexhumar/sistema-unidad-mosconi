<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\BusquedaType;
use Salita\OtrosBundle\Clases\Busqueda;
use Salita\OtrosBundle\Form\Type\BusquedaDiagnosticoType;
use Salita\OtrosBundle\Clases\BusquedaDiagnostico;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AjaxController extends MyController
{

	/*Busqueda de vacuna*/
    public function localidadesDePartidoAction()
    {
    	$repoPartidos = $this->getReposManager()->getPartidosRepo();
    	$idPartido = $this->getRequest()->query->get('data');
    	$localidades = $repoPartidos->localidadesDePartido($idPartido);
    	return $this->render(
	           		'SalitaOtrosBundle:Ajax:localidadesDePartido.html.twig',
    			    array('localidades' => $localidades)
    			);
    }
}