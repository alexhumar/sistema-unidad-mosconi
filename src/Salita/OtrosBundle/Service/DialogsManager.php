<?php
namespace Salita\OtrosBundle\Service;

/*Esta clase contiene todos los mensajes del sistema. Deberia ser util a la hora de aplicarle i18n al sistema*/
class DialogsManager
{
	/*Mensajes de OtrosBundle*/
	
	public function cargaBarrioExitoMsg()
	{
		return 'otrosbundle.barrioForm.new.exito';
	}
	
	public function cargaLocalidadExitoMsg()
	{
		return 'otrosbundle.localidadForm.new.exito';
	}
	
	public function cargaMetodoEstudioExitoMsg()
	{
		return 'otrosbundle.metodoEstudioForm.new.exito';
	}
	
	public function cargaPaisExitoMsg()
	{
		return 'otrosbundle.paisForm.new.exito';
	}
	
	public function cargaPartidoExitoMsg()
	{
		return 'otrosbundle.partidoForm.new.exito';
	}

	public function modificacionPartidoExitoMsg()
	{
		return 'otrosbundle.partidoForm.modif.exito';
	}
	
	public function getDiagnosticoInexistenteMsg()
	{
		return 'otrosbundle.notFoundException.diagnostico';
	}
	
	public function getPartidoInexistenteMsg()
	{
		return 	'otrosbundle.notFoundException.partido';
	}
	
	public function getVacunaInexistenteMsg()
	{
		return 	'otrosbundle.notFoundException.vacuna';
	}
	
	/*Mensajes de PacienteBundle*/
	
	public function getAntecedentesInexistentesMsg()
	{
		return 	'pacientebundle.notFoundException.antecedentes';
	}
	
    public function modificacionAntecedentesExitoMsg()
	{
		return 'pacientebundle.antecedentes.modif.exito';
	}
	
	public function cargaAplicacionVacunaExitoMsg()
	{
		return 'pacientebundle.aplicacionVacuna.new.exito';
	}
	
	public function cargaConsultaExitoMsg()
	{
		return 'pacientebundle.consulta.new.exito';
	}
	
	public function cargaEstudioExitoMsg()
	{
		return 'pacientebundle.estudio.new.exito';
	}
	
	public function modificacionDatosPacienteExitoMsg()
	{
		return 'pacientebundle.paciente.modif.exito';
	}
	
	public function cargaPacienteExitoMsg()
	{
		return 'pacientebundle.paciente.new.exito';
	}
	
	/* Mensajes de PlanBundle */
	
	public function getPlanInexistenteMsg()
	{
		return 	'planbundle.notFoundException.plan';
	}
	
	public function cargaEntregaPlanExitoMsg()
	{
		return 'planbundle.entregaplan.new.exito';
	}
	
	public function cargaMetodoAnticonceptivoExitoMsg()
	{
		return 'planbundle.metodoAnticonceptivo.new.exito';
	}
	
	public function cargaPlanPacienteExitoMsg()
	{
		return 'planbundle.planpaciente.new.exito';
	}
	
	public function getPlanPacienteInexistenteMsg()
	{
		return 	'planbundle.notFoundException.planPaciente';
	}
	
	public function modifPlanPacienteExitoMsg()
	{
		return 'planbundle.planpaciente.modif.exito';
	}
	
	/* Mensajes de TurnoBundle */
	
	public function cargaTurnoPacienteExitoMsg()
	{
		return 'turnobundle.turnopaciente.new.exito';
	}
	
	/* Mensajes de UsuarioBundle */
	
	public function cambioPasswordUsuarioExitoMsg()
	{
		return 'usuariobundle.cambioPassword.exito';
	}
	
	public function getUsuarioInexistenteMsg()
	{
		return 'usuariobundle.notFoundException.usuario';
	}
	
	public function modifUsuarioExitoMsg()
	{
		return 'usuariobundle.cambioDatos.exito';
	}
	
	public function modifUsuarioPropioExitoMsg()
	{
		return 'usuariobundle.cambioDatosPropio.exito';
	}
	
	public function asignacionEspecialidadExitoMsg()
	{
		return 'usuariobundle.asignacionEspecialidad.exito';
	}
	
	public function usuarioNoMedicoErrorMsg()
	{
		return 'usuariobundle.usuarioNoMedico.error';
	}
}