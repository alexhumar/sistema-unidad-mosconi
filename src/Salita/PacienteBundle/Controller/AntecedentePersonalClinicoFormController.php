<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\AntecedentePersonalClinicoType;
use Salita\PacienteBundle\Entity\AntecedentePersonalClinico;
use Salita\OtrosBundle\Clases\MyController;

class AntecedentePersonalClinicoFormController extends MyController
{
    
    /*Modificacion de antecedente personal clinico*/
    public function modifAction()
    {
    	$repoAntecedentes = $this->getReposManager()->getAntecedentesPersonalesClinicosRepo();
    	$session = $this->getSession();
    	$antecedentePersonalClinico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        $translator = $this->getTranslator();
    	if(!$antecedentePersonalClinico)
    	{
    		$mensaje = $this->getDialogsManager()->getAntecedentesInexistentesMsg();
    		throw $this->createNotFoundException($translator->trans($mensaje));
    	}
    	$form = $this->createForm(new AntecedentePersonalClinicoType(), $antecedentePersonalClinico);
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
           			'SalitaPacienteBundle:AntecedentesForm:modifPersonalClinico.html.twig',
           			array('form' => $form->createView())
           		);
    }
}