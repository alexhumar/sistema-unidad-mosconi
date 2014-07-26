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
    	$idPartido = 2;
    	$localidades = $repoLocalidades->localidadesDePartido($idPartido);
    	echo ("Hola1");
    	$html = '';
    	echo ("Hola2");
    	foreach ($localidades as $localidad)
    	{
    		echo ("Hola3");
    		$html = $html . sprintf("<option value=\"%d\">%s</option>", $localidad->getId(), $localidad->getNombre());
    	}
    	/*return $this->render(
	           		'SalitaOtrosBundle:Ajax:localidadesDePartido.html.twig',
    			    array('localidades' => $localidades)
    			);*/
    	echo ("Hola4");
    	return new Response($html);
    }
}