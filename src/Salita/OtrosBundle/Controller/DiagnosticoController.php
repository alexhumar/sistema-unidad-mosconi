<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class DiagnosticoController extends MyController
{

    public function seleccionarAction($idDiagnostico)
    {
       $repoDiagnosticos = $this->getReposManager()->getDiagnosticosRepo();
       $diagnostico = $repoDiagnosticos->find($idDiagnostico);
       if(!$diagnostico)
       {
       		throw $this->createNotFoundException("Diagnostico inexistente");
       }
       $session = $this->getSession();
       $session->set('diagnosticoSeleccionado', $diagnostico); 
       return $this->redirect($this->generateUrl('alta_consulta'));
    }
}