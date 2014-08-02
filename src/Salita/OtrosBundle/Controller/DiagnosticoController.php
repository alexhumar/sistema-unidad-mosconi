<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class DiagnosticoController extends MyController
{

    public function seleccionarAction($idDiagnostico)
    {
       $repoDiagnosticos = $this->getReposManager()->getDiagnosticosRepo();
       $diagnostico = $repoDiagnosticos->find($idDiagnostico);
       $translator = $this->getTranslator();
       $mensaje = $this->getDialogsManager()->getDiagnosticoInexistenteMsg();
       if(!$diagnostico)
       {
       		throw $this->createNotFoundException($translator->trans($mensaje));
       }
       $session = $this->getSession();
       $session->set('diagnosticoSeleccionado', $diagnostico); 
       return $this->redirect($this->generateUrl('alta_consulta'));
    }
}