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
        $barrio= new Barrio();
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
   			$session->set('mensaje', 'El barrio se cargo exitosamente en el sistema');
   			$nextAction = $form->get('guardarynuevo')->isClicked()
				? 'alta_barrio'
				: 'resultado_operacion';
   			return $this->redirect($this->generateUrl($nextAction));
   		}
   		else
   		{
   			$session->set('mensaje', 'El barrio se cargo exitosamente en el sistema');
   			return $this->redirect($this->generateUrl('resultado_operacion'));
   		}
    }
    
    public function resultadoAction(Request $request)
    {
    	$session = $request->getSession();
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
		$mensaje = $session->get('mensaje');
    	return $this->render(
    			'SalitaOtrosBundle:BarrioForm:mensaje.html.twig',
    			array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
    	);
    }
}
