<?php
namespace Salita\OtrosBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VacunaController extends Controller
{
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function getVacunasRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaOtrosBundle:Vacuna');
	}

    public function seleccionarAction(Request $request, $idVacuna)
    {
       $session = $request->getSession();
       $repoVacunas = $this->getVacunasRepo();
       $vacuna = $repoVacunas->find($idVacuna);
       if(!$vacuna)
       {
           throw $this->createNotFoundException("Vacuna inexistente");
       }
       $session->set('vacunaSeleccionada', $vacuna);
       return $this->redirect($this->generateUrl('alta_aplicacion_vacuna'));
    }
}
