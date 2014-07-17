<?php
namespace Salita\OtrosBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class SessionManager
{
	protected $session;
	
	public function __construct(Session $session)
	{
		$this->session = $session;
	}
	
	public function setMensajeResultadoOperacion($nextAction, $mensaje)
	{
		/* Si $nextAction contiene el substring "resultado_operacion" */
		if(strpos($nextAction, "resultado_operacion") !== false)
		{
		    $this->session->set('mensaje', $mensaje);
		}
		else
		{
			$this->session->getFlashBag()->add('mensaje', $mensaje);
		}
	}
}