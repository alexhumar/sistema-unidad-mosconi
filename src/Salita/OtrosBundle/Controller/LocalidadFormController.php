<?php
namespace Salita\OtrosBundle\Controller;
use Salita\OtrosBundle\Form\Type\LocalidadType;
use Salita\OtrosBundle\Entity\Localidad;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocalidadFormController extends Controller
{
	
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function guardarLocalidad($localidad)
	{
		$em = $this->getEntityManager();
		$em->persist($localidad);
		$em->flush();
	}
	
	/*ATENCION: NO HAY RUTA QUE REFERENCIE ESTE CONTROLADOR.*/

	/*Alta de localidad (fase GET)*/
    public function newAction(Request $request)
    {
        $localidad= new Localidad();
        $form = $this->createForm(new LocalidadType(), $localidad);
        return $this->render(
           			'SalitaOtrosBundle:LocalidadForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    /*Alta de localidad (fase POST)*/
    public function newProcessAction(Request $request)
    {
    	$localidad= new Localidad();
    	$form = $this->createForm(new LocalidadType(), $localidad);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->guardarLocalidad($localidad);
   			$mensaje = 'La localidad se cargo exitosamente en el sistema';
   			return $this->render(
   					'SalitaOtrosBundle:LocalidadForm:mensaje.html.twig',
   					array('mensaje' => $mensaje)
   			);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al cargar la localidad al sistema';
   			return $this->render(
   					'SalitaOtrosBundle:LocalidadForm:mensaje.html.twig',
   					array('mensaje' => $mensaje)
   			);
   		}
    }
}
