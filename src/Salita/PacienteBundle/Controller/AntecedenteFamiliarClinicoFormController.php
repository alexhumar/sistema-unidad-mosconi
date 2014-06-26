<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\AntecedenteFamiliarClinicoType;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarClinico;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AntecedenteFamiliarClinicoFormController extends MyController
{
	
	/*Modificacion de antecedente familiar clinico (fase GET)*/ 
	public function modifAction()
    {   
        $session = $this->getSession();   
        $repoAntecedentes = $this->getReposManager()->getAntecedentesFamiliaresClinicosRepo(); 
        $antecedenteFamiliarClinico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        if(!$antecedenteFamiliarClinico)
        {
        	throw $this->createNotFoundException("Antecedentes inexistentes");
        }
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $form = $this->createForm(new AntecedenteFamiliarClinicoType(), $antecedenteFamiliarClinico);
        return $this->render(
           			'SalitaPacienteBundle:AntecedenteFamiliarClinicoForm:modif.html.twig',
           			array('form' => $form->createView(), 'rol' => $rolSeleccionado->getCodigo(), 
           				  'nombreRol' => $rolSeleccionado->getNombre())
           		);
	}
    
    /*Modificacion de antecedente familiar clinico (fase POST)*/
    public function modifProcessAction()
    {
    	$session = $this->getSession();  	
    	$repoAntecedentes = $this->getReposManager()->getAntecedentesFamiliaresClinicosRepo();
    	$antecedenteFamiliarClinico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
    	if(!$antecedenteFamiliarClinico)
    	{
    		throw $this->createNotFoundException("Antecedentes inexistentes");
    	}
    	$form = $this->createForm(new AntecedenteFamiliarClinicoType(), $antecedenteFamiliarClinico);
    	$request = $this->getRequest();
    	$form->handleRequest($request);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	if ($form->isValid())
    	{
    		$em = $this->getEntityManager();
    		//$em->persist($antecedenteFamiliarClinico);
    		$em->flush();
    		$mensaje = 'Los antecedentes del paciente se modificaron exitosamente';
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al modificar los antecedentes del paciente';
    	}
    	return $this->render(
    			'SalitaPacienteBundle:AntecedenteFamiliarClinicoForm:mensaje.html.twig',
    			array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    				  'nombreRol' => $rolSeleccionado->getNombre())
    			);
    }
}