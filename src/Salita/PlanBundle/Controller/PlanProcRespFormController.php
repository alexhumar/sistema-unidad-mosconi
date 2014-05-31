<?php
namespace Salita\PlanBundle\Controller;
use Salita\PlanBundle\Form\Type\PlanProcRespType;
use Salita\PlanBundle\Form\Type\ModPlanProcRespType;
use Salita\PlanBundle\Entity\PlanProcResp;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class PlanProcRespFormController extends Controller
{

    public function newAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $plan = new PlanProcResp();
        $form = $this->createForm(new PlanProcRespType(), $plan);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            if ($form->isValid())
            {
                $paciente = $session->get('paciente');
                $plan->setPaciente($paciente);
                $plan->setFinalizado('0');
                $em->persist($plan);
                $em->flush();
                return $this->render('SalitaPlanBundle:PlanProcRespForm:mensaje.html.twig', array('mensaje' => 'El plan del paciente se agrego  exitosamente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
            else 
            {
                return $this->render('SalitaPlanBundle:PlanProcRespForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar agregar un plan para el paciente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            
            }
        }
        else
        {
            return $this->render('SalitaPlanBundle:PlanProcRespForm:new.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),
            ));
        }
    }

    public function modifAction(Request $request, $idPlan)
    {
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repoPlanes = $em->getRepository('SalitaPlanBundle:PlanProcResp');
        $plan = $repoPlanes->find($idPlan);
        $form = $this->createForm(new ModPlanProcRespType(), $plan);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);   
            if ($form->isValid())
            {
                $em->persist($plan);
                $em->flush();
                return $this->render('SalitaPlanBundle:PlanProcRespForm:mensaje.html.twig', array('mensaje' => 'El plan del paciente se modifico exitosamente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
            else 
            {
                return $this->render('SalitaPlanBundle:PlanProcRespForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar modificar un plan del paciente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
            
        }
        else
        {
            return $this->render('SalitaPlanBundle:PlanProcRespForm:modif.html.twig', array('form' => $form->createView(),'id' => $idPlan,'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),
            ));
        }
    }

    function listAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repoPlanes = $em->getRepository('SalitaPlanBundle:PlanProcResp');
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $planes = $repoPlanes->findAllById($session->get('paciente')->getId());
        return $this->render('SalitaPlanBundle:PlanProcRespForm:listado.html.twig', array('planes' => $planes,'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),
            ));
    }

    function listDesAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repoPlanes = $em->getRepository('SalitaPlanBundle:PlanProcResp');
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $planes = $repoPlanes->findAllByIdDes($session->get('paciente')->getId());
        return $this->render('SalitaPlanBundle:PlanProcRespForm:listadoDes.html.twig', array('planes' => $planes,'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),
            ));
    }

    function habAction(Request $request, $idPlan)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repoPlanes = $em->getRepository('SalitaPlanBundle:PlanProcResp');
        $repoPlanes->habilitar($idPlan);
        return $this->redirect($this->generateUrl('listadoDes_planprocresp'));
    }

    function deshabAction(Request $request, $idPlan)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repoPlanes = $em->getRepository('SalitaPlanBundle:PlanProcResp');
        $repoPlanes->deshabilitar($idPlan);
        return $this->redirect($this->generateUrl('listado_planprocresp'));
    }
}
