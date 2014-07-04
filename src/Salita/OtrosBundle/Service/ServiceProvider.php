<?php
namespace Salita\OtrosBundle\Service\ServiceProvider;

class ServiceProvider
{
	
	protected $container;
	
	public function __construct($container)
	{
		$this->container = $container;
	}
	
	/*Clase que define metodos shortcut a servicios comunes a todos mis controllers*/
	public function getSessionUser()
	{
		return $this->getSecurityContext()->getToken()->getUser();
	}
	
	public function getEntityManager()
	{
		return $this->getReposManager()->getEntityManager();
	}
	
	public function getSecurityContext()
	{
		return $this->container->get('security.context');
	}
	
	public function getSession()
	{
		return $this->container->get('session');
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