<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class DiagnosticoController extends MyController
{

    public function seleccionarAction($idDiagnostico)
    {
       $session = $this->getSession();
       $repoDiagnosticos = $this->getReposManager()->getDiagnosticosRepo();
       $diagnostico = $repoDiagnosticos->find($idDiagnostico);
       if(!$diagnostico)
       {
       		throw $this->createNotFoundException("Diagnostico inexistente");
       }
       $session->set('diagnosticoSeleccionado', $diagnostico); 
       return $this->redirect($this->generateUrl('alta_consulta'));
    }
}