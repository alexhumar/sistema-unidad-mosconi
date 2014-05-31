<?php
namespace Salita\OtrosBundle\Controller;
use Salita\OtrosBundle\Form\Type\LocalidadType;
use Salita\OtrosBundle\Entity\Localidad;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocalidadFormController extends Controller
{

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $localidad= new Localidad();
        $form = $this->createForm(new LocalidadType(), $localidad);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);          
            if ($form->isValid())
            {
                $em->persist($localidad);
                $em->flush();
                return $this->render('SalitaOtrosBundle:LocalidadForm:mensaje.html.twig', array('mensaje' => 'La localidad se cargo exitosamente en el sistema',
            ));
            }
            else 
            {
                return $this->render('SalitaOtrosBundle:LocalidadForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al cargar la localidad al sistema',
            ));
            }
            
        }
        else
        {
            return $this->render('SalitaOtrosBundle:LocalidadForm:new.html.twig', array('form' => $form->createView(),
            ));
        }
    }
}
