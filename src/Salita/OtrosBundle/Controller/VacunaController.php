<?php
namespace Salita\OtrosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VacunaController extends Controller
{

    public function seleccionarAction(Request $request, $idVacuna)
    {
       $session = $request->getSession();
       $repoVacunas = $this->get('repos_manager')->getVacunasRepo();
       $vacuna = $repoVacunas->find($idVacuna);
       if(!$vacuna)
       {
           throw $this->createNotFoundException("Vacuna inexistente");
       }
       $session->set('vacunaSeleccionada', $vacuna);
       return $this->redirect($this->generateUrl('alta_aplicacion_vacuna'));
    }
}