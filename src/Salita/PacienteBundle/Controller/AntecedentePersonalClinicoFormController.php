<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\AntecedentePersonalClinicoType;
use Salita\PacienteBundle\Entity\AntecedentePersonalClinico;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AntecedentePersonalClinicoFormController extends MyController
{

	/*Modificacion de antecedente personal clinico (fase GET)*/
    public function modifAction()
    {        
        $session = $this->getSession();
        $repoAntecedentes = $this->getReposManager()->getAntecedentesPersonalesClinicosRepo();
        $antecedentePersonalClinico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        if(!$antecedentePersonalClinico)
        {
        	throw $this->createNotFoundException("Antecedente inexistente");
        }
        $form = $this->createForm(new AntecedentePersonalClinicoType(), $antecedentePersonalClinico);
        return $this->render(
           			'SalitaPacienteBundle:AntecedentePersonalClinicoForm:modif.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    /*Modificacion de antecedente personal clinico (fase POST)*/
    public function modifProcessAction()
    {
    	$session = $this->getSession();
    	$repoAntecedentes = $this->getReposManager()->getAntecedentesPersonalesClinicosRepo();
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
    		//$em->persist($antecedentePersonalClinico);
    		$em->flush();
    		$mensaje = 'Los antecedentes del paciente se modificaron exitosamente';
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al modificar los antecedentes del paciente';
    	}
    	return $this->render(
    				'SalitaPacienteBundle:AntecedentePersonalClinicoForm:mensaje.html.twig',
    				array('mensaje' => $mensaje)
    			);
    }
}