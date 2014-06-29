<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\AntecedenteFamiliarObstetricoType;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarObstetrico;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AntecedenteFamiliarObstetricoFormController extends MyController
{
    
	/*Modificacion de antecedentes familiares obstetricos (fase GET)*/
    public function modifAction()
    {      
        $session = $this->getSession();
        $repoAntecedentes = $this->getReposManager()->getAntecedentesFamiliaresObstetricosRepo();
        $antecedenteFamiliarObstetrico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        if(!$antecedenteFamiliarObstetrico)
        {
        	throw $this->createNotFoundException("Antecedentes inexistentes");
        }
        $form = $this->createForm(new AntecedenteFamiliarObstetricoType(), $antecedenteFamiliarObstetrico);
        return $this->render(
        			'SalitaPacienteBundle:AntecedenteFamiliarObstetricoForm:modif.html.twig',
            		array('form' => $form->createView())
            	);
    }
    
    /*Modificacion de antecedentes familiares obstetricos (fase POST)*/
    public function modifProcessAction()
    {
    	$session = $this->getSession();
    	$repoAntecedentes = $this->getReposManager()->getAntecedentesFamiliaresObstetricosRepo();
    	$antecedenteFamiliarObstetrico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
    	if(!$antecedenteFamiliarObstetrico)
    	{
    		throw $this->createNotFoundException("Antecedentes inexistentes");
    	}
    	$form = $this->createForm(new AntecedenteFamiliarObstetricoType(), $antecedenteFamiliarObstetrico);
    	$request = $this->getRequest();
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getEntityManager();
    		//$em->persist($antecedenteFamiliarObstetrico);
    		$em->flush();
    		$mensaje = 'Los antecedentes del paciente se modificaron exitosamente';
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al modificar los antecedentes del paciente';
    	}
    	return $this->render(
    				'SalitaPacienteBundle:AntecedenteFamiliarObstetricoForm:mensaje.html.twig',
    				array('mensaje' => $mensaje)
    			);
    }
}