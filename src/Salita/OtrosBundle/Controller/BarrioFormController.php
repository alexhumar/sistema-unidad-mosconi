<?php
namespace Salita\OtrosBundle\Controller;
use Salita\OtrosBundle\Form\Type\BarrioType;
use Salita\OtrosBundle\Entity\Barrio;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class BarrioFormController extends Controller
{

    public function newAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $barrio= new Barrio();
        $form = $this->createForm(new BarrioType(), $barrio);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);     
            if ($form->isValid())
            {
                $em->persist($barrio);
                $em->flush();
                return $this->render('SalitaOtrosBundle:BarrioForm:mensaje.html.twig', array('mensaje' => 'El barrio se cargo exitosamente en el sistema','rol' => $rolSeleccionado->getCodigo(),));
            }
            else 
            {
                return $this->render('SalitaOtrosBundle:BarrioForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar cargar el barrio al sistema','rol' => $rolSeleccionado->getCodigo(),
            ));
            }
        }
        else
        {
            return $this->render('SalitaOtrosBundle:BarrioForm:new.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),
            ));
        }
    }
}
