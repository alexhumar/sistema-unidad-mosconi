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
    	if(!$antecedentePersonalClinico)
    	{
    		throw $this->createNotFoundException("Antecedente inexistente");
    	}
    	$form = $this->createForm(new AntecedentePersonalClinicoType(), $antecedentePersonalClinico);
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
           			'SalitaPacienteBundle:AntecedentesForm:modif.html.twig',
           			array('form' => $form->createView())
           		);
    }
}