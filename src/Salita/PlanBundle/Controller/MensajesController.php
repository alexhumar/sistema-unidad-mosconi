<?php
namespace Salita\PlanBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class MensajesController extends MyController
{
	
    /* Debe ser utilizado dentro de PlanBundle para generar los mensajes cuyo template extienda de
     * PlanBundle::base.html.twig, para visualizar el menu (nav) de paciente */
    public function resultadoAction()
    {
    	$mensaje = $this->getSession()->get('mensaje');
    	return $this->render(
    			'SalitaPlanBundle:Form:mensaje.html.twig',
    			array('mensaje' => $mensaje)
    	);
    }
}