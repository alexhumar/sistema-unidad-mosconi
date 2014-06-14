<?php
namespace Salita\UsuarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MensajesController extends Controller
{
    
    public function resultadoAction(Request $request)
    {
    	$session = $request->getSession();
		$mensaje = $session->get('mensaje');
    	return $this->render(
    				'SalitaUsuarioBundle:Form:mensaje.html.twig',
    				array('mensaje' => $mensaje)
    		);
    }
}