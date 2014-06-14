<?php
namespace Salita\OtrosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class MensajesController extends Controller
{
    
    public function resultadoAction(Request $request)
    {
    	$session = $request->getSession();
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
		$mensaje = $session->get('mensaje');
    	return $this->render(
    			'SalitaOtrosBundle:Form:mensaje.html.twig',
    			array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
    	);
    }
}