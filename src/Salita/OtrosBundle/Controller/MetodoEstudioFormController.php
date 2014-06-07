<?php
namespace Salita\OtrosBundle\Controller;
use Salita\OtrosBundle\Form\Type\MetodoEstudioType;
use Salita\OtrosBundle\Entity\MetodoEstudio;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class MetodoEstudioFormController extends Controller
{
	
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function guardarMetodoDeEstudio($metodo)
	{
		$em = $this->getEntityManager();
		$em->persist($metodo);
		$em->flush();
	}

	/*Alta de metodo de estudio (fase GET)*/
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $metodo= new MetodoEstudio();
        $form = $this->createForm(new MetodoEstudioType(), $metodo);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaOtrosBundle:MetodoEstudioForm:new.html.twig',
           			array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo())
           		);
    }
    
    /*Alta de metodo de estudio (fase POST)*/
    public function newProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	$metodo= new MetodoEstudio();
    	$form = $this->createForm(new MetodoEstudioType(), $metodo);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->guardarMetodoDeEstudio($metodo);
   			$mensaje = 'El metodo de estudio se cargo exitosamente en el sistema';
   			return $this->render(
   					'SalitaOtrosBundle:MetodoEstudioForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
   			);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar el metodo de estudio al sistema';
   			return $this->render(
   					'SalitaOtrosBundle:MetodoEstudioForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
   			);
   		}
    }
}
