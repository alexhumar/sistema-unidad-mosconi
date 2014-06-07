<?php
namespace Salita\OtrosBundle\Controller;
use Salita\OtrosBundle\Form\Type\BarrioType;
use Salita\OtrosBundle\Entity\Barrio;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class BarrioFormController extends Controller
{
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function guardarBarrio($barrio)
	{
		$em = $this->getEntityManager();
		$em->persist($barrio);
		$em->flush();
	}

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
    	$session = $request->getSession();
    	$barrio= new Barrio();
    	$form = $this->createForm(new BarrioType(), $barrio);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->guardarBarrio($barrio);
   			$mensaje = 'El barrio se cargo exitosamente en el sistema';
   			return $this->render(
   					'SalitaOtrosBundle:BarrioForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
   			);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar el barrio al sistema';
   			return $this->render(
   					'SalitaOtrosBundle:BarrioForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
   			);
   		}
    }
}
