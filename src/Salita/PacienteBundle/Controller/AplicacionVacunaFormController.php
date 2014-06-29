<?php
namespace Salita\PacienteBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AplicacionVacunaFormController extends MyController
{

    public function newAction()
    {
       $session = $this->getSession();
       if (!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {
           if (!$session->has('vacunaSeleccionada'))
           {
                return $this->redirect($this->generateUrl('busqueda_vacuna'));
           }
           else
           {    
                $paciente = $session->get('paciente');
                $vacuna = $session->get('vacunaSeleccionada');
                $this->getPersistenceManager()->createAplicacionVacuna($paciente, $vacuna);
                $session->remove('vacunaSeleccionada');
           }
       }
       return $this->redirect($this->generateUrl('menu_paciente'));
    }

    public function listAction()
    {
        $session = $this->getSession();
        if (!$session->has('paciente'))
        {
            return $this->redirect($this->generateUrl('busqueda_paciente'));
        }
        else
        {
            $repoPacientes = $this->getReposManager()->getPacientesRepo();           
            $aplicaciones = $repoPacientes->aplicacionesVacuna($session->get('paciente')->getId());
            return $this->render(
            			'SalitaPacienteBundle:AplicacionVacuna:list.html.twig',
            			array('aplicaciones' => $aplicaciones)
            		);
        }
    }    
}