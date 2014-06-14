<?php
namespace Salita\OtrosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DiagnosticoController extends Controller
{

    public function seleccionarAction(Request $request, $idDiagnostico)
    {
       $session = $request->getSession();
       $repoDiagnosticos = $this->get('repos_manager')->getDiagnosticosRepo();
       $diagnostico = $repoDiagnosticos->find($idDiagnostico);
       if(!$diagnostico)
       {
       		throw $this->createNotFoundException("Diagnostico inexistente");
       }
       $session->set('diagnosticoSeleccionado', $diagnostico); 
       return $this->redirect($this->generateUrl('alta_consulta'));
    }
}
