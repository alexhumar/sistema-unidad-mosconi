<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\AntecedentePersonalObstetricoType;
use Salita\PacienteBundle\Entity\AntecedentePersonalObstetrico;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AntecedentePersonalObstetricoFormController extends Controller
{
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function getAntecedentesPersonalesObstetricosRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:AntecedentePersonalObstetrico');
	}
	
	/*Modificacion de antecedente personal obstetrico (fase GET)*/
    public function modifAction(Request $request)
    {
        $session = $request->getSession();
        $repoAntecedentes = $this->getAntecedentesPersonalesObstetricosRepo(); 
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
    public function modifProcessAction(Request $request)
    {
    	$session = $request->getSession();  	
    	$repoAntecedentes = $this->getAntecedentesPersonalesObstetricosRepo();
    	$antecedentePersonalObstetrico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
    	if (!$antecedentePersonalObstetrico)
    	{
    		throw $this->createNotFoundException("Antecedente inexistente");
    	}
    	$form = $this->createForm(new AntecedentePersonalObstetricoType(), $antecedentePersonalObstetrico);
    	$form->handleRequest($request);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	if ($form->isValid())
    	{
    		$em = $this->getEntityManager();
    		//$em->persist($antecedentePersonalObstetrico);
    		$em->flush();
    		$mensaje = 'Los antecedentes del paciente se modificaron exitosamente';
    		return $this->render(
    				'SalitaPacienteBundle:AntecedentePersonalObstetricoForm:mensaje.html.twig',
    				array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    					  'nombreRol' => $rolSeleccionado->getNombre())
    		);
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al modificar los antecedentes del paciente';
    		return $this->render(
    				'SalitaPacienteBundle:AntecedentePersonalObstetricoForm:mensaje.html.twig',
    				array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    					  'nombreRol' => $rolSeleccionado->getNombre())
    		);
    	}
    }
}
