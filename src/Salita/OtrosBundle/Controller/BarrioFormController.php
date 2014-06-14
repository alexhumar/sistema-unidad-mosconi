<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\BarrioType;
use Salita\OtrosBundle\Entity\Barrio;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class BarrioFormController extends Controller
{

	/*Alta de barrio (fase GET)*/
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $barrio = new Barrio();
        $form = $this->createForm(new BarrioType(), $barrio);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaOtrosBundle:BarrioForm:new.html.twig',
           			array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo())
           		);
    }
    
    /*Alta de barrio (fase POST)*/
    public function newProcessAction(Request $request)
    {
    	$barrio = new Barrio();
    	$form = $this->createForm(new BarrioType(), $barrio);
   		$form->handleRequest($request);
   		$session = $request->getSession();
   		if ($form->isValid())
   		{
   			$this->get('persistence_manager')->saveBarrio($barrio);
   			$mensaje = 'El barrio se cargo exitosamente en el sistema';
   			$session->getFlashBag()->add('mensaje', $mensaje);
   			$session->set('mensaje', $mensaje);
   			$nextAction = $form->get('guardarynuevo')->isClicked()
				? 'alta_barrio'
				: 'resultado_operacion';
   			return $this->redirect($this->generateUrl($nextAction));
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al cargar un barrio en el sistema';
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion'));
   		}
    }
}