<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\AntecedentePersonalObstetricoType;
use Salita\PacienteBundle\Entity\AntecedentePersonalObstetrico;
use Salita\OtrosBundle\Clases\MyController;

class AntecedentePersonalObstetricoFormController extends MyController
{
    
    /*Modificacion de antecedente personal obstetrico (fase GET)*/
    public function modifAction()
    { 	
    	$repoAntecedentes = $this->getReposManager()->getAntecedentesPersonalesObstetricosRepo();
    	$session = $this->getSession();
    	$antecedentePersonalObstetrico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        $translator = $this->getTranslator();
    	if (!$antecedentePersonalObstetrico)
    	{
    		$mensaje = $this->getDialogsManager()->getAntecedentesInexistentesMsg();
    		throw $this->createNotFoundException($translator->trans($mensaje));
    	}
    	$form = $this->createForm(new AntecedentePersonalObstetricoType(), $antecedentePersonalObstetrico);
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
           			'SalitaPacienteBundle:AntecedentesForm:modifPersonalObstetrico.html.twig',
           			array('form' => $form->createView())
           		);
    }
}