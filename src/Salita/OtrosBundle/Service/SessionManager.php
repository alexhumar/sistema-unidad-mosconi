<?php
namespace Salita\OtrosBundle\Service;

use Symfony\Component\HttpFoundation\Session;

class SessionManager
{
	protected $session;
	
	public function __construct($session)
	{
		$this->session = $session;
	}
	
	public function setMensajeResultadoOperacion($nextAction, $mensaje)
	{
		if($nextAction = "resultado_operacion")
		{
		    $this->session->set('mensaje', $mensaje);
		    return "Trabaja con sesion";
		}
		else
		{
			$this->session->getFlashBag()->add('mensaje', $mensaje);
			return "Trabaja con flashbag";
		}
	}
}