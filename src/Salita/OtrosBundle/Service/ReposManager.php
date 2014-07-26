<?php
namespace Salita\OtrosBundle\Service;

use Doctrine\ORM\EntityManager;

class ReposManager
{
	protected $em;
	
	public function __construct(EntityManager $entitymanager)
	{
		$this->em = $entitymanager;
	}
	
	public function getEntityManager()
	{
		return $this->em;
	}
	
	/*Repos de PacienteBundle*/
	public function getAntecedentesFamiliaresClinicosRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaPacienteBundle:AntecedenteFamiliarClinico');
	}
	
	public function getAntecedentesFamiliaresObstetricosRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaPacienteBundle:AntecedenteFamiliarObstetrico');
	}
	
	public function getAntecedentesPersonalesClinicosRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaPacienteBundle:AntecedentePersonalClinico');
	}
	
	public function getAntecedentesPersonalesObstetricosRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaPacienteBundle:AntecedentePersonalObstetrico');
	}
	
	public function getConsultasRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaPacienteBundle:Consulta');
	}
	
	public function getEstudiosRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaPacienteBundle:Estudio');
	}
	
	public function getPacientesRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaPacienteBundle:Paciente');
	}
	
	/*Repos de PlanBundle*/
	public function getEntregasPlanProcreacionResponsableRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaPlanBundle:EntregaPlanProcResp');
	}
	
	public function getPlanesProcreacionResponsableRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaPlanBundle:PlanProcResp');
	}
	
	/*Repos de TurnoBundle*/
	public function getTurnosRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaTurnoBundle:Turno');
	}
	
	/*Repos de UsuarioBundle*/
	public function getUsuariosRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaUsuarioBundle:Usuario');
	}
	
	public function getRolesRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaUsuarioBundle:Rol');
	}
	
	/*Repos de OtrosBundle*/
	public function getAplicacionesVacunasRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaOtrosBundle:AplicacionVacuna');
	}
	
	public function getDiagnosticosRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaOtrosBundle:Diagnostico');
	}
	
	public function getPartidosRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaOtrosBundle:Partido');
	}
	
	public function getBarriosRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaOtrosBundle:Barrio');
	}
	
	public function getLocalidadesRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaOtrosBundle:Localidad');
	}
	
	public function getVacunasRepo()
	{
		return $this->getEntityManager()->getRepository('SalitaOtrosBundle:Vacuna');
	}	
}