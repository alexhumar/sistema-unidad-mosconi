<?php
namespace Salita\PacienteBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SeleccionController extends Controller
{
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function getPacientesRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:Paciente');
	}

    public function seleccionarAction(Request $request, $idPaciente)
    {
       $session = $request->getSession();
       $repoPacientes = $this->getPacientesRepo();
       $paciente = $repoPacientes->find($idPaciente);
       $session->set('paciente', $paciente);
       return $this->redirect($this->generateUrl('menu_paciente'));
    }
}
