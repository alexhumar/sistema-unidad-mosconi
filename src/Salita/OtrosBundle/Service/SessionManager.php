<?php
namespace Salita\OtrosBundle\Service;

use Symfony\Component\HttpFoundation\Session;

class SessionManager
{
	protected $session;
	
	public function __construct(Session $session)
	{
		$this->session = $session;
	}
	
	/*Implementar los getters y setters de las diferentes cosas que guardo 
	 * en la sesion (usuarios, pacientes, etc)*/
}