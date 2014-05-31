<?php
namespace Salita\PlanBundle\Controller;
use Salita\PlanBundle\Form\Type\EntregaPlanProcRespType;
use Salita\PlanBundle\Entity\EntregaPlanProcResp;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class EntregaPlanProcRespFormController extends Controller
{

    public function newAction(Request $request, $idPlan)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repoPlanes = $em->getRepository('SalitaPlanBundle:PlanProcResp');
        $entrega= new EntregaPlanProcResp();
        $form = $this->createForm(new EntregaPlanProcRespType(), $entrega);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request); 
            if ($form->isValid())
            {
                $plan = $repoPlanes->find($idPlan);
                $entrega->setFecha(date("d-m-Y"));
                $entrega->setPlan($plan);
                $em->persist($entrega);
                $em->flush();
                return $this->render('SalitaPlanBundle:EntregaPlanProcRespForm:mensaje.html.twig', array('mensaje' => 'La entrega del plan se registro correctamente','rol' => $rolSeleccionado->getCodigo()));
            }
            else 
            {
                return $this->render('SalitaPlanBundle:EntregaPlanProcRespForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar registrar una entrega del plan','rol' => $rolSeleccionado->getCodigo()));
            }
        }
        else
        {
            return $this->render('SalitaPlanBundle:EntregaPlanProcRespForm:new.html.twig', array('form' => $form->createView(), 'id' => $idPlan,'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre()));
        }
    }

    function listAction(Request $request, $idPlan)
    {
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repoPlanes = $em->getRepository('SalitaPlanBundle:PlanProcResp');
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $entregasplanprocresp = $repoPlanes->encontrarTodosOrdenadosPorFecha($idPlan);
        return $this->render('SalitaPlanBundle:EntregaPlanProcRespForm:listado.html.twig', array('entregasplanprocresp' => $entregasplanprocresp,'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
    }
}
