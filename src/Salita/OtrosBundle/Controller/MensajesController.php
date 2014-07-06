<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class MensajesController extends MyController
{
    
	/* Debe ser utilizado por todo bundle que genere un template de mensaje que extienda de
	 * ::base.html.twig, para que se visualice el menu (nav) de usuario. */
    public function resultadoAction()
    {
    	$mensaje = $this->getSession()->get('mensaje');
    	return $this->render(
    			'SalitaOtrosBundle:Form:mensaje.html.twig',
    			array('mensaje' => $mensaje)
    	);
    }
}