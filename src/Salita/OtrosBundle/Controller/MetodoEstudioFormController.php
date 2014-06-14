<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\MetodoEstudioType;
use Salita\OtrosBundle\Entity\MetodoEstudio;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class MetodoEstudioFormController extends Controller
{
	
	/*Alta de metodo de estudio (fase GET)*/
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $metodo = new MetodoEstudio();
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
    	$metodo = new MetodoEstudio();
    	$form = $this->createForm(new MetodoEstudioType(), $metodo);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->get('persistence_manager')->saveMetodoDeEstudio($metodo);
   			$mensaje = 'El metodo de estudio se cargo exitosamente en el sistema';
   			$session->set('mensaje', $mensaje);
   			$session->getFlashBag()->add('mensaje', $mensaje);
   			$nextAction = $form->get('guardarynuevo')->isClicked()
   				? 'alta_metodoestudio'
   				: 'resultado_operacion';
   			return $this->redirect($this->generateUrl($nextAction));
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar el metodo de estudio al sistema';
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion'));
   		}
    }
}