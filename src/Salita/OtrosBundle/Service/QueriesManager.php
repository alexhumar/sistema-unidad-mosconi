<?php

namespace Salita\TurnoBundle\Service;

use Salita\OtrosBundle\Service\ReposManager;

class QueriesManager
{
	protected $reposManager;
	
	public function __construct(ReposManager $reposManager)
	{
		$this->reposManager = $reposManager;
	}
	
	/*Implementar metodos accessors a las diversas queries de los repositorios*/
}