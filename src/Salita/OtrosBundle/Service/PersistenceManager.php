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
		$em = $this->getReposManager()->getEntityManager();
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

	public function savePartido($partido)
	{
		$em = $this->getReposManager()->getEntityManager();
		$em->persist($partido);
		$em->flush();
	}
	
	public function updatePartido($partido)
	{
		/* $partido se obtuvo de una consulta al repositorio de partidos,
		 * por lo que no es necesaria la ejecucion del metodo persist*/
		$em = $this->getReposManager()->getEntityManager();
		//$em->persist($partido);
		$em->flush();
	}
	
	/*Metodos de UsuarioBundle*/
	public function assignRolAUsuario($usuario, $rol)
	{
		/*Aclaracion: tanto el usuario como el rol deben venir traidos de sus respectivos repos*/
		$usuario->setEnabled(true);
		$usuario->agregarRol($rol);
		$em = $this->getReposManager()->getEntityManager();
		//no hace falta--$em->persist($usuario);
		$em->flush();
	}
	
	public function removeUsuario($usuario)
	{
		/*Aclaracion: el usuario debe venir traido del repo de usuarios*/
		$em = $this->getReposManager()->getEntityManager();
		$em->remove($usuario);
		$em->flush();
	}
	
	public function removeRolAUsuario($usuario, $rol)
	{
		/*Aclaracion: tanto el usuario como el rol deben venir traidos de sus respectivos repos*/
		$usuario->quitarRol($rol);
		$em = $this->getReposManager()->getEntityManager();
		$em->flush();
	}
	
	/*Metodos de PlanBundle*/
	public function saveEntregaPlanProcreacionResponsable($plan, $entrega)
	{
		$entrega->setFecha(date("d-m-Y"));
		$entrega->setPlan($plan);
		$em = $this->getReposManager()->getEntityManager();
		/*Como el plan se obtuvo del repo, esta "seguido" por doctrine. Como la entrega se asocia al plan
		 * el persist no haria falta ya que la entrega deberia almacenarse gracias a la persistencia en cascada*/
		//$em->persist($entrega);
		$em->flush();
	}
	
	public function saveMetodoAnticonceptivo($metodo)
	{
		$em = $this->getReposManager()->getEntityManager();
		$em->persist($metodo);
		$em->flush();
	}
	
	public function savePlanProcreacionResponsable($plan, $paciente)
	{
		$plan->setPaciente($paciente);
		$plan->setFinalizado('0');
		$em = $this->getReposManager()->getEntityManager();
		$em->persist($plan);
		$em->flush();
	}
	
	public function updatePlanProcreacionResponsable($plan)
	{
		$em = $this->getEntityManager();
		/*Plan es un objeto "vigilado" por Doctrine, por lo que no es necesaria la invocacion
		 * del metodo persist*/
		$em->flush();
	}
}