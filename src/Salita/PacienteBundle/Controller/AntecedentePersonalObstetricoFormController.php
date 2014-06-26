<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\AntecedentePersonalObstetricoType;
use Salita\PacienteBundle\Entity\AntecedentePersonalObstetrico;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AntecedentePersonalObstetricoFormController extends MyController
{
	
	/*Modificacion de antecedente personal obstetrico (fase GET)*/
    public function modifAction()
    {
        $session = $this->getSession();
        $repoAntecedentes = $this->getReposManager()->getAntecedentesPersonalesObstetricosRepo(); 
        $antecedentePersonalObstetrico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        if (!$antecedentePersonalObstetrico)
        {
        	throw $this->createNotFoundException("Antecedente inexistente");
        }
        $form = $this->createForm(new AntecedentePersonalObstetricoType(), $antecedentePersonalObstetrico);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaPacienteBundle:AntecedentePersonalObstetricoForm:modif.html.twig',
           			array('form' => $form->createView(), 'rol' => $rolSeleccionado->getCodigo(), 
           				  'nombreRol' => $rolSeleccionado->getNombre())
           		);
    }
    
    /*Modificacion de antecedente personal obstetrico (fase GET)*/
    public function modifProcessAction()
    {
    	$session = $this->getSession();  	
    	$repoAntecedentes = $this->getReposManager()->getAntecedentesPersonalesObstetricosRepo();
    	$antecedentePersonalObstetrico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
    	if (!$antecedentePersonalObstetrico)
    	{
    		throw $this->createNotFoundException("Antecedente inexistente");
    	}
    	$form = $this->createForm(new AntecedentePersonalObstetricoType(), $antecedentePersonalObstetrico);
    	$request = $this->getRequest();
    	$form->handleRequest($request);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	if ($form->isValid())
    	{
    		$em = $this->getEntityManager();
    		//$em->persist($antecedentePersonalObstetrico);
    		$em->flush();
    		$mensaje = 'Los antecedentes del paciente se modificaron exitosamente';
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al modificar los antecedentes del paciente';
    	}
    	return $this->render(
    			'SalitaPacienteBundle:AntecedentePersonalObstetricoForm:mensaje.html.twig',
    			array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    				  'nombreRol' => $rolSeleccionado->getNombre())
    			);
    }
}