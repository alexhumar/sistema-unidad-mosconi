<?php
namespace Salita\PacienteBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class AplicacionVacunaFormController extends MyController
{

    public function newAction()
    {
       $session = $this->getSession();
       if (!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       if (!$session->has('vacunaSeleccionada'))
       {
           return $this->redirect($this->generateUrl('busqueda_vacuna'));
       }  
       $paciente = $session->get('paciente');
       $vacuna = $session->get('vacunaSeleccionada');
       $this->getPersistenceManager()->createAplicacionVacuna($paciente, $vacuna);
       $mensaje = "La aplicacion de vacuna fue registrada exitosamente";
       $session->set('mensaje', $mensaje);
       $session->remove('vacunaSeleccionada');
       return $this->redirect($this->generateUrl('resultado_operacion_paciente'));
    }

    public function listAction()
    {
        $session = $this->getSession();
        if (!$session->has('paciente'))
        {
            return $this->redirect($this->generateUrl('busqueda_paciente'));
        }
        $repoAplicacionesVacunas = $this->getReposManager()->getAplicacionesVacunasRepo();           
        $aplicaciones = $repoAplicacionesVacunas->aplicacionesVacuna($session->get('paciente')->getId());
        return $this->render(
   	    			'SalitaPacienteBundle:AplicacionVacuna:list.html.twig',
   	    			array('aplicaciones' => $aplicaciones)
 	      		);
    }    
}