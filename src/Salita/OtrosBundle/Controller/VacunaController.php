<?php
namespace Salita\OtrosBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VacunaController extends Controller
{

    public function seleccionarAction(Request $request, $idVacuna)
    {
       //$session = $this->container->get('session');
       $session = $this->container->get('request')->getSession();
       $em = $this->getDoctrine()->getEntityManager();
       $repoVacunas = $em->getRepository('SalitaOtrosBundle:Vacuna');
       $vacuna = $repoVacunas->finOneById($idVacuna);
       $session->set('vacunaSeleccionada', $vacuna);
       return $this->redirect($this->generateUrl('alta_aplicacion_vacuna'));
    }
}
