<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\AntecedenteFamiliarObstetricoType;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarObstetrico;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AntecedenteFamiliarObstetricoFormController extends Controller
{
	private function getEntityManager()
	{
		return $this->getDoctrine()->getEntityManager();
	}
	
	private function getAntecedentesFamiliaresObstetricosRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:AntecedenteFamiliarObstetrico');
	}
    
	/*Modificacion de antecedentes familiares obstetricos (fase GET)*/
    public function modifAction(Request $request)
    {      
        $session = $request->getSession();
        $repoAntecedentes = $this->getAntecedentesFamiliaresObstetricosRepo();
        $antecedenteFamiliarObstetrico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        if(!$antecedenteFamiliarObstetrico)
        {
        	throw $this->createNotFoundException("Antecedentes inexistentes");
        }
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $form = $this->createForm(new AntecedenteFamiliarObstetricoType(), $antecedenteFamiliarObstetrico);
        return $this->render(
        			'SalitaPacienteBundle:AntecedenteFamiliarObstetricoForm:modif.html.twig',
            		array('form' => $form->createView(), 'rol' => $rolSeleccionado->getCodigo(), 
            			  'nombreRol' => $rolSeleccionado->getNombre())
            	);
    }
    
    /*Modificacion de antecedentes familiares obstetricos (fase POST)*/
    public function modifProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	$repoAntecedentes = $this->getAntecedentesFamiliaresObstetricosRepo();
    	$antecedenteFamiliarObstetrico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
    	if(!$antecedenteFamiliarObstetrico)
    	{
    		throw $this->createNotFoundException("Antecedentes inexistentes");
    	}
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	$form = $this->createForm(new AntecedenteFamiliarObstetricoType(), $antecedenteFamiliarObstetrico);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getEntityManager();
    		$em->persist($antecedenteFamiliarObstetrico);
    		$em->flush();
    		$mensaje = 'Los antecedentes del paciente se modificaron exitosamente';
    		return $this->render(
    				'SalitaPacienteBundle:AntecedenteFamiliarObstetricoForm:mensaje.html.twig',
    				array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    					  'nombreRol' => $rolSeleccionado->getNombre())
    			);
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al modificar los antecedentes del paciente';
    		return $this->render(
    				'SalitaPacienteBundle:AntecedenteFamiliarObstetricoForm:mensaje.html.twig',
    				array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
    					  'nombreRol' => $rolSeleccionado->getNombre())
    			);
    	}
    }
}
