<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class VacunaController extends MyController
{

    public function seleccionarAction($idVacuna)
    {
       $repoVacunas = $this->getReposManager()->getVacunasRepo();
       $vacuna = $repoVacunas->find($idVacuna);
       if(!$vacuna)
       {
           throw $this->createNotFoundException("Vacuna inexistente");
       }
       $session = $this->getSession();
       $session->set('vacunaSeleccionada', $vacuna);
       return $this->redirect($this->generateUrl('alta_aplicacion_vacuna'));
    }
}