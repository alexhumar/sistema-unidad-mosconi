<?php
namespace Salita\OtrosBundle\Controller;
use Salita\OtrosBundle\Form\Type\MetodoEstudioType;
use Salita\OtrosBundle\Entity\MetodoEstudio;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class MetodoEstudioFormController extends Controller
{

    public function newAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $metodo= new MetodoEstudio();
        $form = $this->createForm(new MetodoEstudioType(), $metodo);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);         
            if ($form->isValid())
            {
                $em->persist($metodo);
                $em->flush();
                return $this->render('SalitaOtrosBundle:MetodoEstudioForm:mensaje.html.twig', array('mensaje' => 'El metodo de estudio se cargo exitosamente en el sistema','rol' => $rolSeleccionado->getCodigo(),));
            }
            else 
            {
                return $this->render('SalitaOtrosBundle:MetodoEstudioForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar cargar el metodo de estudio al sistema','rol' => $rolSeleccionado->getCodigo()));
            }
            
        }
        else
        {
            return $this->render('SalitaOtrosBundle:MetodoEstudioForm:new.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),
            ));
        }
    }
}
