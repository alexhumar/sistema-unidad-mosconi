<?php
namespace Salita\PacienteBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class SeleccionController extends MyController
{

    public function seleccionarAction($idPaciente)
    {
       $session = $this->getSession();
       $repoPacientes = $this->getReposManager()->getPacientesRepo();
       $paciente = $repoPacientes->find($idPaciente);
       $session->set('paciente', $paciente);
       return $this->redirect($this->generateUrl('menu_paciente'));
    }
}