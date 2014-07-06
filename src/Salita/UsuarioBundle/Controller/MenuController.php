<?php
namespace Salita\UsuarioBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class MenuController extends MyController
{
	
	public function principalAction()
	{
		return $this->render('SalitaUsuarioBundle:Menu:principal.html.twig');
	}
}