<?php
namespace Salita\PlanBundle\Controller;
use Salita\PlanBundle\Form\Type\MetodoAnticonceptivoType;
use Salita\PlanBundle\Entity\MetodoAnticonceptivo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class MetodoAnticonceptivoFormController extends Controller
{

    public function newAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $metodo= new MetodoAnticonceptivo();
        $form = $this->createForm(new MetodoAnticonceptivoType(), $metodo);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);   
            if ($form->isValid())
            {
                $em->persist($metodo);
                $em->flush();
                return $this->render('SalitaPlanBundle:MetodoAnticonceptivoForm:mensaje.html.twig', array('mensaje' => 'El metodo anticonceptivo se cargo exitosamente en el sistema','rol' => $rolSeleccionado->getCodigo(),));
            }
            else 
            {
                return $this->render('SalitaPlanBundle:MetodoAnticonceptivoForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar cargar el metodo anticonceptivo al sistema','rol' => $rolSeleccionado->getCodigo(),));
            }
        }
        else
        {
            return $this->render('SalitaPlanBundle:MetodoAnticonceptivoForm:new.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),
            ));
        }
    }
}
