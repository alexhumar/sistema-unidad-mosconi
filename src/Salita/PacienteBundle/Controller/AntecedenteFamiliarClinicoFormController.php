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
    	if(!$antecedenteFamiliarClinico)
    	{
    		throw $this->createNotFoundException("Antecedentes inexistentes");
    	}
    	$form = $this->createForm(new AntecedenteFamiliarClinicoType(), $antecedenteFamiliarClinico);
    	$request = $this->getRequest();
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getEntityManager();
    		$em->flush();
    		$mensaje = 'Los antecedentes del paciente se modificaron exitosamente';
    		$session->set('mensaje', $mensaje);
    		return $this->redirect($this->generateUrl('resultado_operacion_paciente'));
    	}
    	return $this->render(
    			'SalitaPacienteBundle:AntecedentesForm:modifFamiliarClinico.html.twig',
    			array('form' => $form->createView())
    	);
    }
}