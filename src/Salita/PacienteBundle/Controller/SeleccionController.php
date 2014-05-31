<?php
namespace Salita\PacienteBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SeleccionController extends Controller
{

    public function seleccionarAction(Request $request, $idPaciente)
    {
       //$session = $this->container->get('session');
       $session = $this->container->get('request')->getSession();
       $repoPacientes = $this->getDoctrine()->getEntityManager()->getRepository('SalitaPacienteBundle:Paciente');
       $paciente = $repoPacientes->findOneById($idPaciente);
       $session->set('paciente', $paciente);
       return $this->redirect($this->generateUrl('menu_paciente'));
    }
}
