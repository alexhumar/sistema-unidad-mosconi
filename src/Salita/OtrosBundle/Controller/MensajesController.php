<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class MensajesController extends MyController
{
    
    public function resultadoAction()
    {
    	$session = $this->getSession();
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
		$mensaje = $session->get('mensaje');
    	return $this->render(
    			'SalitaOtrosBundle:Form:mensaje.html.twig',
    			array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
    	);
    }
}