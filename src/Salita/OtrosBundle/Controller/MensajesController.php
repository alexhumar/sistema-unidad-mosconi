<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class MensajesController extends MyController
{
    
    public function resultadoAction()
    {
    	$session = $this->getSession();
		$mensaje = $session->get('mensaje');
		/* Aca podria limpiar el flashbag asociado, sino la proxima vez que de de alta algo (un barrio por ej.
		 * me aparece el flashmessage debido a que no fue consumido */
    	return $this->render(
    			'SalitaOtrosBundle:Form:mensaje.html.twig',
    			array('mensaje' => $mensaje)
    	);
    }
}