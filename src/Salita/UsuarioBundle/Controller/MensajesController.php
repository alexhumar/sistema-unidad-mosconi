<?php
namespace Salita\UsuarioBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class MensajesController extends MyController
{
	
    /* Debe ser utilizado dentro de UsuarioBundle para generar los mensajes cuyo template extienda de
     * UsuarioBundle::base.html.twig, para visualizar el menu (nav) de usuario */
    public function resultadoAction()
    {
    	$mensaje = $this->getSession()->get('mensaje');
    	return $this->render(
    			'SalitaUsuarioBundle:Form:mensaje.html.twig',
    			array('mensaje' => $mensaje)
    	);
    }
}