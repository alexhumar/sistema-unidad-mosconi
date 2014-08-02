<?php
namespace Salita\OtrosBundle\Service;

/*Esta clase contiene todos los mensajes del sistema. Deberia ser util a la hora de aplicarle i18n al sistema*/
class DialogsManager
{
	/*Mensajes de OtrosBundle*/
	public function cargaBarrioExitoMsg()
	{
		return 'El barrio se cargo exitosamente en el sistema';
	}
	
	public function cargaLocalidadExitoMsg()
	{
		return 'La localidad se cargo exitosamente en el sistema';
	}
	
	public function cargaMetodoEstudioExitoMsg()
	{
		return 'El metodo de estudio se cargo exitosamente en el sistema';
	}
	
	public function cargaPaisExitoMsg()
	{
		return 'El pais se cargo exitosamente en el sistema';
	}
	
	public function cargaPartidoExitoMsg()
	{
		return 'El partido se cargo exitosamente en el sistema';
	}

	public function modificacionPartidoExitoMsg()
	{
		return 'El partido fue modificado exitosamente';
	}
	
	public function getDiagnosticoInexistenteMsg()
	{
		return 'Diagnostico inexistente';
	}
	
	public function getPartidoInexistenteMsg()
	{
		return 	'Partido inexistente';
	}
	
	public function getVacunaInexistenteMsg()
	{
		return 	'Vacuna inexistente';
	}
	
	
	
}