<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\AntecedenteFamiliarClinicoType;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarClinico;
use Salita\OtrosBundle\Clases\MyController;

class AntecedenteFamiliarClinicoFormController extends MyController
{
	
    /*Modificacion de antecedente familiar clinico*/
    public function modifAction()
    { 	
    	$repoAntecedentes = $this->getReposManager()->getAntecedentesFamiliaresClinicosRepo();
    	$session = $this->getSession();
    	$antecedenteFamiliarClinico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        $translator = $this->getTranslator();
    	if(!$antecedenteFamiliarClinico)
    	{
    		$mensaje = $this->getDialogsManager()->getAntecedentesInexistentesMsg();
    		throw $this->createNotFoundException($translator->trans($mensaje));
    	}
    	$form = $this->createForm(new AntecedenteFamiliarClinicoType(), $antecedenteFamiliarClinico);
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
    			'SalitaPacienteBundle:AntecedentesForm:modifFamiliarClinico.html.twig',
    			array('form' => $form->createView())
    	);
    }
}