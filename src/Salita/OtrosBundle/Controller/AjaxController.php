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
    	$repoPartidos = $this->getReposManager()->getPartidosRepo();
    	$idPartido = $this->getRequest()->query->get('data');
    	$localidades = $repoPartidos->localidadesDePartido($idPartido);
    	$html = '';
    	foreach ($localidades as $localidad)
    	{
    		$html = $html . sprintf("<option value=\"%d\">%s</option>", $localidad->getId(), $localidad->getNombre());
    	}
    	/*return $this->render(
	           		'SalitaOtrosBundle:Ajax:localidadesDePartido.html.twig',
    			    array('localidades' => $localidades)
    			);*/
    	return new Response($html);
    }
}