<?php

namespace Salita\OtrosBundle\Service;

use Salita\OtrosBundle\Service\ReposManager;

class PersistenceManager
{
	protected $reposManager;
	
	public function __construct(ReposManager $reposManager)
	{
		$this->reposManager = $reposManager;
	}
	
	public function getReposManager()
	{
		return $this->reposManager;
	}
	
	/*Metodos de TurnoBundle*/
	public function saveTurno($turno, $medico, $paciente, $fecha, $hora)
	{
		$em = $this->getReposManager()->getEntityManager();
		/*Si no agrego esto, falla doctrine... como que necesita que los objetos vengan de los repos asi les
		 * mantiene la pista*/
		$repoPacientes = $this->getReposManager()->getPacientesRepo();
		$repoUsuarios = $this->getReposManager()->getUsuariosRepo();
		$paciente = $repoPacientes->find($paciente->getId());
		$medico = $repoUsuarios->find($medico->getId());
		$turno->setPaciente($paciente);
		$turno->setUsuario($medico);
		$turno->setFecha($fecha);
		$turno->setHora($hora);
		$turno->setAtendido(false);
		$em->persist($turno);
		$em->flush();
	}
	
	public function saveNowTurno($turno, $medico, $paciente)
	{
		$this->saveTurno($turno, $medico, $paciente, date("d-m-Y"), date("H:i:s"));
	}
	
	public function setTurnoAtendido($idTurno, $controller)
	{
		$em = $this->getReposManager()->getEntityManager();
		$repoTurnos = $this->getReposManager()->getTurnosRepo();
		$turno = $repoTurnos->find($idTurno);
		if(!$turno)
		{
			throw $controller->createNotFoundException("No existe el turno solicitado");
		}
		$turno->setAtendido(true);
		$em->persist($turno);
		$em->flush();
	}
	
	/*Metodos de OtrosBundle*/
	public function saveBarrio($barrio)
	{
		$em = $this->getReposManager()->getEntityManager();
		$em->persist($barrio);
		$em->flush();
	}
	
	public function saveLocalidad($localidad)
	{
		$em = $this->getReposManager()->getEntityManager();
		$em->persist($localidad);
		$em->flush();
	}
	
	public function saveMetodoDeEstudio($metodo)
	{
		$em = $this->getReposManager()->getEntityManager();
		$em->persist($metodo);
		$em->flush();
	}
	
	public function savePais($pais)
	{
		$em = $this->getReposManager()->getEntityManager();
		$em->persist($pais);
		$em->flush();
	}

	private function savePartido($partido)
	{
		$em = $this->getReposManager()->getEntityManager();
		$em->persist($partido);
		$em->flush();
	}
	
	private function updatePartido($partido)
	{
		/* $partido se obtuvo de una consulta al repositorio de partidos,
		 * por lo que no es necesaria la ejecucion del metodo persist*/
		$em = $this->getReposManager()->getEntityManager();
		//$em->persist($partido);
		$em->flush();
	}
	

}