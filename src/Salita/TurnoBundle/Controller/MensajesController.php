<?php
namespace Salita\TurnoBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class MensajesController extends MyController
{
	
    /* Debe ser utilizado dentro de TurnoBundle para generar los mensajes cuyo template extienda de
     * TurnoBundle::base.html.twig, para visualizar el menu (nav) de paciente */
    public function resultadoAction()
    {
    	$mensaje = $this->getSession()->get('mensaje');
    	return $this->render(
    			'SalitaTurnoBundle:Form:mensaje.html.twig',
    			array('mensaje' => $mensaje)
    	);
    }
}