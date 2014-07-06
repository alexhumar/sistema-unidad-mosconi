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
    		$em->flush();
    		$mensaje = 'Los antecedentes del paciente se modificaron exitosamente';
    		$session->set('mensaje', $mensaje);
    		return $this->redirect($this->generateUrl('resultado_operacion_paciente'));
    	}
    	return $this->render(
    				'SalitaPacienteBundle:AntecedenteFamiliarObstetricoForm:modif.html.twig',
    				array('form' => $form->createView())
    			);
    }
}