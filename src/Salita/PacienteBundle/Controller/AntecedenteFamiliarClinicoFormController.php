<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\AntecedenteFamiliarClinicoType;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarClinico;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AntecedenteFamiliarClinicoFormController extends Controller
{
	private function getEntityManager()
	{
		return $this->getDoctrine()->getEntityManager();
	}
	
	private function getAntecedentesFamiliaresClinicosRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:AntecedenteFamiliarClinico');
	}
    
	/*Modificacion de antecedente familiar clinico (fase GET)*/ 
	public function modifAction(Request $request)
    {   
        $session = $request->getSession();   
        $repoAntecedentes = $this->getAntecedentesFamiliaresClinicosRepo(); 
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
    public function modifProcessAction(Request $request)
    {
    	$session = $request->getSession();  	
    	$repoAntecedentes = $this->getAntecedentesFamiliaresClinicosRepo();
    	$antecedenteFamiliarClinico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
    	if(!$antecedenteFamiliarClinico)
    	{
    		throw $this->createNotFoundException("Antecedentes inexistentes");
    	}
    	$form = $this->createForm(new AntecedenteFamiliarClinicoType(), $antecedenteFamiliarClinico);
    	$form->handleRequest($request);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	if ($form->isValid())
    	{
    		$em = $this->getEntityManager();
    		//$em->persist($antecedenteFamiliarClinico);
    		$em->flush();
    		$mensaje = 'Los antecedentes del paciente se modificaron exitosamente';
    		return $this->render(
    					'SalitaPacienteBundle:AntecedenteFamiliarClinicoForm:mensaje.html.twig',
    					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    						  'nombreRol' => $rolSeleccionado->getNombre())
    				);
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al modificar los antecedentes del paciente';
    		return $this->render(
    					'SalitaPacienteBundle:AntecedenteFamiliarClinicoForm:mensaje.html.twig',
    					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    						  'nombreRol' => $rolSeleccionado->getNombre())
    				);
    	}
    }
}
