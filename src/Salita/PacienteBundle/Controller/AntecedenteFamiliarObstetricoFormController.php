<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\AntecedenteFamiliarObstetricoType;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarObstetrico;
use Salita\OtrosBundle\Clases\MyController;

class AntecedenteFamiliarObstetricoFormController extends MyController
{
    
    /*Modificacion de antecedentes familiares obstetricos*/
    public function modifAction()
    {
    	$repoAntecedentes = $this->getReposManager()->getAntecedentesFamiliaresObstetricosRepo();
    	$session = $this->getSession();
    	$antecedenteFamiliarObstetrico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        $translator = $this->getTranslator();
    	if(!$antecedenteFamiliarObstetrico)
    	{
    		$mensaje = $this->getDialogsManager()->getAntecedentesInexistentesMsg();
    		throw $this->createNotFoundException($translator->trans($mensaje));
    	}
    	$form = $this->createForm(new AntecedenteFamiliarObstetricoType(), $antecedenteFamiliarObstetrico);
    	$request = $this->getRequest();
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getEntityManager();
    		$em->flush();
    		$mensaje = $this->getDialogsManager()->modificacionAntecedentesExitoMsg();
    		$session->set('mensaje', $translator->trans($mensaje));
    		return $this->redirect($this->generateUrl('resultado_operacion_paciente'));
    	}
    	return $this->render(
    				'SalitaPacienteBundle:AntecedentesForm:modifFamiliarObstetrico.html.twig',
    				array('form' => $form->createView())
    			);
    }
}