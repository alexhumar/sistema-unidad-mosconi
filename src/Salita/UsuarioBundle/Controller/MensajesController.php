<?php
namespace Salita\UsuarioBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class MensajesController extends MyController
{
    
    public function resultadoAction()
    {
    	$session = $this->getSession();
		$mensaje = $session->get('mensaje');
    	return $this->render(
    				'SalitaUsuarioBundle:Form:mensaje.html.twig',
    				array('mensaje' => $mensaje)
    		);
    }
}