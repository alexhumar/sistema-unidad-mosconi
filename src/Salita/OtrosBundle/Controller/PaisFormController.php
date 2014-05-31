<?php
namespace Salita\OtrosBundle\Controller;
use Salita\OtrosBundle\Form\Type\PaisType;
use Salita\OtrosBundle\Entity\Pais;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PaisFormController extends Controller
{

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $pais= new Pais();
        $form = $this->createForm(new PaisType(), $pais);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);          
            if ($form->isValid())
            {
                $em->persist($pais);
                $em->flush();
                return $this->render('SalitaOtrosBundle:PaisForm:mensaje.html.twig', array('mensaje' => 'El pais se cargo exitosamente en el sistema',
            ));
            }
            else 
            {
                return $this->render('SalitaOtrosBundle:PaisForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar cargar un pais en el sistema',
            ));
            }
            
        }
        else
        {
            return $this->render('SalitaOtrosBundle:PaisForm:new.html.twig', array('form' => $form->createView(),
            ));
        }
    }
}
