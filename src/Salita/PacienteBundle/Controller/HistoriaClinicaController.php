<?php
namespace Salita\PacienteBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\PacienteBundle\Form\Type\FechasResumenHCType;
use Salita\OtrosBundle\Clases\ConsultaRol;
use Salita\OtrosBundle\Clases\FechasResumenHC;

class HistoriaClinicaController extends Controller
{
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function getAplicacionesVacunasRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaOtrosBundle:AplicacionVacuna');
	}
	
	private function getEstudiosRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:Estudio');
	}
	
	private function getConsultasRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:Consulta');
	}
		
	private function getAntecedentesPersonalesClinicosRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:AntecedentePersonalClinico');
	}
	
	private function getAntecedentesFamiliaresClinicosRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:AntecedenteFamiliarClinico');
	}
	
	private function getAntecedentesPersonalesObstetricosRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:AntecedentePersonalObstetrico');
	}
	
	private function getAntecedentesFamiliaresObstetricosRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:AntecedenteFamiliarObstetrico');
	}
	
    private function ordenarVisitasPorFecha($toOrderArray, $field, $inverse = false)
    {  
        $position = array();  
        $newRow = array();  
        foreach ($toOrderArray as $key => $row)
        {  
            $position[$key]  = \DateTime::createFromFormat('d-m-Y', $row[$field]); 
            $newRow[$key] = $row;  
        }  
        if ($inverse)
        {  
            arsort($position);  
        }  
        else 
        {  
            asort($position);  
        }  
        $returnArray = array();  
        foreach ($position as $key => $pos)
        {       
            $returnArray[] = $newRow[$key];  
        }  
        return $returnArray;  
    }  

    private function visitasEntreFechas($visitas,$fechaDesde,$fechaHasta)
    {
        $resultado = array();
        foreach($visitas as $visita)
        {
            $fechaVisita = \DateTime::createFromFormat('d-m-Y', $visita['fecha']);
            if (($fechaVisita >= $fechaDesde) and ($fechaVisita <= $fechaHasta))
            {
                $resultado[] = $visita;
            }
        }
        return $resultado;
    }

    public function generarAction(Request $request)
    {
       $session = $request->getSession();
       if(!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {
           $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
           $paciente = $session->get('paciente');
           $idPaciente = $paciente->getId();
           /*Consultas*/
           $repoConsultas = $this->getConsultasRepo();
           $consultas = $repoConsultas->obtenerConsultasDePaciente($idPaciente);
           /*Estudios*/
           $repoEstudios = $this->getEstudiosRepo();
           $estudios = $repoEstudios->obtenerEstudiosDePaciente($idPaciente);
           /*Ordenamiento de visitas*/
           $consultas = $this->ordenarVisitasPorFecha($consultas,'fecha');
           $estudios = $this->ordenarVisitasPorFecha($estudios,'fecha');
           /*Aplicaciones de vacunas*/ 
           $repoAplicacionesVacuna = $this->getAplicacionesVacunasRepo();
           $aplicaciones = $repoAplicacionesVacuna->aplicacionesVacunaDePaciente($idPaciente);
		   /*Antecedentes personales clinicos*/
           $repoAntecedentesPersonalesClinicos = $this->getAntecedentesPersonalesClinicosRepo();
           $antecedentePersonalClinico = $repoAntecedentesPersonalesClinicos->buscarAntecedenteDePaciente($idPaciente);
           /*Antecedentes familiares clinicos*/
           $repoAntecedentesFamiliaresClinicos = $this->getAntecedentesFamiliaresClinicosRepo();
           $antecedenteFamiliarClinico = $repoAntecedentesFamiliaresClinicos->buscarAntecedenteDePaciente($idPaciente); 
           /*LO QUE ESTABA ANTES-POR LAS DUDAS: if($paciente->getSexo() == '1')*/
           if($paciente->isMujer())
           {
           	   /*Antecedentes personales obstetricos*/
               $repoAntecedentesPersonalesObstetricos = $this->getAntecedentesPersonalesObstetricosRepo();
               $antecedentePersonalObstetrico = $repoAntecedentesPersonalesObstetricos->buscarAntecedenteDePaciente($idPaciente); 
               /*Antecedentes familiares obstetricos*/
               $repoAntecedentesFamiliaresObstetricos = $this->getAntecedentesFamiliaresObstetricosRepo();
               $antecedenteFamiliarObstetrico = $repoAntecedentesFamiliaresObstetricos->buscarAntecedenteDePaciente($idPaciente);
           }
           else
           {
               $antecedentePersonalObstetrico = null;
               $antecedenteFamiliarObstetrico = null;
           }
           $usuarioGenerador = $session->get('usuario');          
           return $this->render(
           			'SalitaPacienteBundle:HistoriaClinica:generacionHC.html.twig', 
           			array('paciente' => $paciente,'antecedentePC' => $antecedentePersonalClinico,
           				  'antecedenteFC' => $antecedenteFamiliarClinico,
           				  'antecedenteFO' => $antecedenteFamiliarObstetrico,
           				  'antecedentePO' => $antecedentePersonalObstetrico,
           				  'consultas' => $consultas, 'estudios' => $estudios, 
           				  'usuarioGenerador' => $usuarioGenerador, 'rol' => $rolSeleccionado->getCodigo(),
           				  'nombreRol' => $rolSeleccionado->getNombre(), 'aplicaciones' => $aplicaciones)
           		);
       }
    }
    
    public function resumenAction(Request $request)
    {
       $session = $this->container->get('request')->getSession();
       if(!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {
           if(!$session->has('fechaDesde'))
           {
               return $this->redirect($this->generateUrl('fechas_resumenHC'));
           }      
           $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
           $paciente = $session->get('paciente');
           $idPaciente = $paciente->getId();
           $fechaDesde = \DateTime::createFromFormat('d-m-Y', $session->get('fechaDesde'));
           $fechaHasta = \DateTime::createFromFormat('d-m-Y', $session->get('fechaHasta'));
           $repoEstudios = $this->getEstudiosRepo();
           $repoConsultas = $this->getConsultasRepo();
           $consultas = $repoConsultas->obtenerConsultasDePaciente($idPaciente);
           $estudios = $repoEstudios->obtenerEstudiosDePaciente($idPaciente); 
           $consultas = $this->visitasEntreFechas($consultas, $fechaDesde, $fechaHasta);
           $consultas = $this->ordenarVisitasPorFecha($consultas, 'fecha');
           $estudios = $this->visitasEntreFechas($estudios, $fechaDesde, $fechaHasta);
           $estudios = $this->ordenarVisitasPorFecha($estudios, 'fecha');
           $usuarioGenerador = $session->get('usuario');
           $session->remove('fechaDesde');
           $session->remove('fechaHasta');                  
           return $this->render(
           			'SalitaPacienteBundle:HistoriaClinica:resumenHC.html.twig',
           			array('paciente' => $paciente ,'consultas' => $consultas, 
           				  'usuarioGenerador' => $usuarioGenerador, 'estudios' => $estudios, 
           				  'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre())
           		);
       }
    }

    /*Eleccion de fechas para el resumen de historia clinica (fase GET)*/
    public function elegirFechasAction(Request $request)
    {
       $session = $request->getSession();
       if(!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {
           $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
           $fechas = new FechasResumenHC();
           $form = $this->createForm(new FechasResumenHCType(), $fechas);
           return $this->render(
           			'SalitaPacienteBundle:HistoriaClinica:ingresoFechas.html.twig', 
           			array('form' => $form->createView(),'rol' =>  $rolSeleccionado->getCodigo(), 
           				  'nombreRol' => $rolSeleccionado->getNombre())
           		);
       }
    }
    
    /*Eleccion de fechas para el resumen de historia clinica (fase POST)*/
    public function elegirFechasProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	if(!$session->has('paciente'))
    	{
    		return $this->redirect($this->generateUrl('busqueda_paciente'));
    	}
    	else
    	{
    		$fechas = new FechasResumenHC();
    		$form = $this->createForm(new FechasResumenHCType(), $fechas);
   			$form->handleRequest($request);
   			if ($form->isValid())
   			{
   				$session->set('fechaDesde', $fechas->getFechaDesde());
   				$session->set('fechaHasta', $fechas->getFechaHasta());
   				return $this->redirect($this->generateUrl('generar_resumenHC'));
   			}
    	}
    }
}
