<?php
namespace Salita\PacienteBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class MensajesController extends MyController
{
	
    /* Debe ser utilizado dentro de PacienteBundle para generar los mensajes cuyo template extienda de
     * PacienteBundle::base.html.twig, para visualizar el menu (nav) de paciente */
    public function resultadoAction()
    {
    	$mensaje = $this->getSession()->get('mensaje');
    	return $this->render(
    			'SalitaPacienteBundle:Form:mensaje.html.twig',
    			array('mensaje' => $mensaje)
    	);
    }
}