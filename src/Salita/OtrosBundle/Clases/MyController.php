<?php
namespace Salita\OtrosBundle\Clases;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyController extends Controller
{
	/*Clase que define metodos shortcut comunes a todos mis controllers*/
	protected function getSessionUser()
	{
		return $this->getSecurityContext()->getToken()->getUser();
	}
	
	protected function getSecurityContext()
	{
		return $this->container->get('security.context');
	}
	
	protected function getSession()
	{
		return $this->get('session');
	}
	
	protected function getSessionManager()
	{
		return $this->get('session_manager');
	}
	
	protected function getPersistenceManager()
	{
		return $this->get('persistence_manager');
	}
	
	protected function getReposManager()
	{
		return $this->get('repos_manager');
	}
	
	protected function getRolesManager()
	{
		return $this->get('roles_manager');
	}
	
	protected function getDialogsManager()
	{
		return $this->get('dialogs_manager');
	}
	
	protected function getTranslator()
	{
		return $this->get('translator');
	}
	
	protected function getEntityManager()
	{
		return $this->getReposManager()->getEntityManager();
	}
}