<?php
namespace Salita\OtrosBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DiagnosticoController extends Controller
{

    public function seleccionarAction(Request $request, $idDiagnostico)
    {
       //$session = $this->container->get('session');
       $session = $this->container->get('request')->getSession();
       $em = $this->getDoctrine()->getEntityManager();
       $repoDiagnosticos = $em->getRepository('SalitaOtrosBundle:Diagnostico');
       $diagnostico = $repoDiagnosticos->finOneById($idDiagnostico);
       $session->set('diagnosticoSeleccionado', $diagnostico); 
       return $this->redirect($this->generateUrl('alta_consulta'));
    }
}
