<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\AntecedentePersonalClinicoType;
use Salita\PacienteBundle\Entity\AntecedentePersonalClinico;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AntecedentePersonalClinicoFormController extends Controller
{
	private function getEntityManager()
	{
		return $this->getDoctrine()->getEntityManager();
	}
	
	private function getAntecedentesPersonalesClinicosRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:AntecedentePersonalClinico');
	}

	/*Modificacion de antecedente personal clinico (fase GET)*/
    public function modifAction(Request $request)
    {        
        $session = $request->getSession();
        $repoAntecedentes = $this->getAntecedentesPersonalesClinicosRepo();
        $antecedentePersonalClinico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        if(!$antecedentePersonalClinico)
        {
        	throw $this->createNotFoundException("Antecedente inexistente");
        }
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $form = $this->createForm(new AntecedentePersonalClinicoType(), $antecedentePersonalClinico);
        return $this->render(
           			'SalitaPacienteBundle:AntecedentePersonalClinicoForm:modif.html.twig',
           			array('form' => $form->createView(), 'rol' => $rolSeleccionado->getCodigo(),
           				  'nombreRol' => $rolSeleccionado->getNombre())
           		);
    }
    
    /*Modificacion de antecedente personal clinico (fase POST)*/
    public function modifProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	$repoAntecedentes = $this->getAntecedentesPersonalesClinicosRepo();
    	$antecedentePersonalClinico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
    	if(!$antecedentePersonalClinico)
    	{
    		throw $this->createNotFoundException("Antecedente inexistente");
    	}
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	$form = $this->createForm(new AntecedentePersonalClinicoType(), $antecedentePersonalClinico);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getDoctrine()->getEntityManager();
    		$em->persist($antecedentePersonalClinico);
    		$em->flush();
    		$mensaje = 'Los antecedentes del paciente se modificaron exitosamente';
    		return $this->render(
    				'SalitaPacienteBundle:AntecedentePersonalClinicoForm:mensaje.html.twig',
    				array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    					  'nombreRol' => $rolSeleccionado->getNombre())
    		);
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al modificar los antecedentes del paciente';
    		return $this->render(
    				'SalitaPacienteBundle:AntecedentePersonalClinicoForm:mensaje.html.twig',
    				array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    					  'nombreRol' => $rolSeleccionado->getNombre())
    		);
    	}
    }
}
