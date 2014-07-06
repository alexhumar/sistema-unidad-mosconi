<?php
namespace Salita\OtrosBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceProvider
{
	
	protected $container;
	
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
	
	/*Clase que define metodos shortcut a servicios comunes a todos mis controllers. Solo la utilizo,
	 * al 06/07/2014, en el controller de alta de barrio, que esta definido como servicio.*/

	public function getSecurityContext()
	{
		return $this->container->get('security.context');
	}
	
	public function getSession()
	{
		return $this->container->get('session');
	}
	
	public function getSessionManager()
	{
		return $this->container->get('my_session_manager');
	}
	
	public function getPersistenceManager()
	{
		return $this->container->get('persistence_manager');
	}
	
	public function getReposManager()
	{
		return $this->container->get('repos_manager');
	}
	
	public function getRequest()
	{
		return $this->container->get('request');
	}
	
	public function getFormFactory()
	{
		return $this->container->get('form.factory');
	}
	
	public function getHttpKernel()
	{
		return $this->container->get('http_kernel');
	}
	
	public function getTemplating()
	{
		return $this->container->get('templating');
	}
	
	public function getRouter()
	{
		return $this->container->get('router');
	}
}