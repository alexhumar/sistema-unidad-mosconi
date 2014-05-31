<?php
namespace Salita\PacienteBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\PacienteBundle\Form\Type\FechasResumenHCType;
use Salita\OtrosBundle\Clases\ConsultaRol;
use Salita\OtrosBundle\Clases\FechasResumenHC;

class HistoriaClinicaController extends Controller
{

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
       //$session = $this->container->get('session');
       $session = $this->container->get('request')->getSession();
       if(!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {
           $repoAplicacionesVacuna = $this->getDoctrine()->getRepository('SalitaOtrosBundle:AplicacionVacuna');
           $repoEstudios = $this->getDoctrine()->getRepository('SalitaPacienteBundle:Estudio');
           $repoConsultas = $this->getDoctrine()->getRepository('SalitaPacienteBundle:Consulta');
           $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
           $paciente = $session->get('paciente');

           $repAntecedentePersonalClinico = $this->getDoctrine()->getRepository('SalitaPacienteBundle:AntecedentePersonalClinico');
           $antecedentePersonalClinico = $repAntecedentePersonalClinico->buscarAntecedenteDePaciente($paciente->getId());
           
           $repAntecedenteFamiliarClinico = $this->getDoctrine()->getRepository('SalitaPacienteBundle:AntecedenteFamiliarClinico');
           $antecedenteFamiliarClinico = $repAntecedenteFamiliarClinico->buscarAntecedenteDePaciente($paciente->getId()); 
           
           if($paciente->getSexo() == '1')
           {
           $repAntecedentePersonalObstetrico = $this->getDoctrine()->getRepository('SalitaPacienteBundle:AntecedentePersonalObstetrico');
           $antecedentePersonalObstetrico = $repAntecedentePersonalObstetrico->buscarAntecedenteDePaciente($paciente->getId()); 
           
           $repAntecedenteFamiliarObstetrico = $this->getDoctrine()->getRepository('SalitaPacienteBundle:AntecedenteFamiliarObstetrico');
           $antecedenteFamiliarObstetrico = $repAntecedenteFamiliarObstetrico->buscarAntecedenteDePaciente($paciente->getId());
           }
           else
           {
               $antecedentePersonalObstetrico = null;
               $antecedenteFamiliarObstetrico = null;
           }

           $consultas = $repoConsultas->obtenerConsultasDePaciente($paciente->getId());
           $estudios = $repoEstudios->obtenerEstudiosDePaciente($paciente->getId());

           $consultas = $this->ordenarVisitasPorFecha($consultas,'fecha');
           $estudios = $this->ordenarVisitasPorFecha($estudios,'fecha');

           $usuarioGenerador = $session->get('usuario');

           $aplicaciones = $repoAplicacionesVacuna->aplicacionesVacunaDePaciente($paciente->getId());
           
           return $this->render('SalitaPacienteBundle:HistoriaClinica:generacionHC.html.twig', array('paciente' => $paciente,'antecedentePC' => $antecedentePersonalClinico,'antecedenteFC' => $antecedenteFamiliarClinico,'antecedenteFO' => $antecedenteFamiliarObstetrico,'antecedentePO' => $antecedentePersonalObstetrico,'consultas' => $consultas, 'estudios' => $estudios, 'usuarioGenerador' => $usuarioGenerador, 'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(), 'aplicaciones' => $aplicaciones ));
       }
    }
    
    public function resumenAction(Request $request)
    {
       //$session = $this->container->get('session');
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
           $repoEstudios = $this->getDoctrine()->getRepository('SalitaPacienteBundle:Estudio');
           $repoConsultas = $this->getDoctrine()->getRepository('SalitaPacienteBundle:Consulta');
           $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
           $paciente = $session->get('paciente'); 
           $consultas = $repoConsultas->obtenerConsultasDePaciente($paciente->getId());
           $estudios = $repoEstudios->obtenerEstudiosDePaciente($paciente->getId());
           $fechaDesde = \DateTime::createFromFormat('d-m-Y', $session->get('fechaDesde'));
           $fechaHasta = \DateTime::createFromFormat('d-m-Y', $session->get('fechaHasta'));  
           $consultas = $this->visitasEntreFechas($consultas, $fechaDesde, $fechaHasta);
           $consultas = $this->ordenarVisitasPorFecha($consultas, 'fecha');
           $estudios = $this->visitasEntreFechas($estudios, $fechaDesde, $fechaHasta);
           $estudios = $this->ordenarVisitasPorFecha($estudios, 'fecha');
           $usuarioGenerador = $session->get('usuario');
           $session->remove('fechaDesde');
           $session->remove('fechaHasta');
                    
           return $this->render('SalitaPacienteBundle:HistoriaClinica:resumenHC.html.twig', array('paciente' => $paciente ,'consultas' => $consultas, 'usuarioGenerador' => $usuarioGenerador, 'estudios' => $estudios, 'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre() ));
       }
    }

    public function elegirFechasAction(Request $request)
    {
       //$session = $this->container->get('session');
       $session = $this->container->get('request')->getSession();
       if(!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {
           $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
           $fechas = new FechasResumenHC();
           $form = $this->createForm(new FechasResumenHCType(), $fechas);
           if ($request->getMethod() == 'POST')
           {
               $form->bindRequest($request);
               if ($form->isValid())
               {
                   $session->set('fechaDesde', $fechas->getFechaDesde());
                   $session->set('fechaHasta', $fechas->getFechaHasta());
                   return $this->redirect($this->generateUrl('generar_resumenHC'));
               }
           }
           else
           {
               return $this->render('SalitaPacienteBundle:HistoriaClinica:ingresoFechas.html.twig', array('form' => $form->createView(),'rol' =>  $rolSeleccionado->getCodigo(), 'nombreRol' => $rolSeleccionado->getNombre()));
           }
       }
    }
}
