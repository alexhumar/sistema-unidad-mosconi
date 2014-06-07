<?php
namespace Salita\PlanBundle\Controller;
use Salita\PlanBundle\Form\Type\MetodoAnticonceptivoType;
use Salita\PlanBundle\Entity\MetodoAnticonceptivo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class MetodoAnticonceptivoFormController extends Controller
{
	
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function guardarMetodoAnticonceptivo($metodo)
	{
		$em = $this->getEntityManager();
		$em->persist($metodo);
		$em->flush();
	}

	/*Alta de metodo anticonceptivo (fase GET)*/
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $metodo = new MetodoAnticonceptivo();
        $form = $this->createForm(new MetodoAnticonceptivoType(), $metodo);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaPlanBundle:MetodoAnticonceptivoForm:new.html.twig',
           			array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo())
           		);
    }
    
    /*Alta de metodo anticonceptivo (fase POST)*/
    public function newProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	$metodo = new MetodoAnticonceptivo();
    	$form = $this->createForm(new MetodoAnticonceptivoType(), $metodo);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->guardarMetodoAnticonceptivo($metodo);
   			$mensaje = 'El metodo anticonceptivo se cargo exitosamente en el sistema';
   			return $this->render(
   					'SalitaPlanBundle:MetodoAnticonceptivoForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
   			);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar cargar el metodo anticonceptivo al sistema';
   			return $this->render(
   					'SalitaPlanBundle:MetodoAnticonceptivoForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
   			);
   		}
    }
}
