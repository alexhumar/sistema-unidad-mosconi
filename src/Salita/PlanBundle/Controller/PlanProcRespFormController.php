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

	/*Alta de plan de procreacion responsable (fase GET)*/
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $plan = new PlanProcResp();
        $form = $this->createForm(new PlanProcRespType(), $plan);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaPlanBundle:PlanProcRespForm:new.html.twig',
           			array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),
           				  'nombreRol' => $rolSeleccionado->getNombre())
           		);
    }
    
    /*Alta de plan de procreacion responsable (fase POST)*/
    public function newProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	$plan = new PlanProcResp();
    	$form = $this->createForm(new PlanProcRespType(), $plan);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$paciente = $session->get('paciente');
   			$this->get('persistence_manager')->savePlanProcreacionResponsable($plan, $paciente);
   			$mensaje = 'El plan del paciente se agrego  exitosamente';
   			return $this->render(
   						'SalitaPlanBundle:PlanProcRespForm:mensaje.html.twig',
   						array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
   							  'nombreRol' => $rolSeleccionado->getNombre())
   					);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar agregar un plan para el paciente';
   			return $this->render(
   						'SalitaPlanBundle:PlanProcRespForm:mensaje.html.twig',
   						array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
   							  'nombreRol' => $rolSeleccionado->getNombre())
   					);
		}
    }

    /*Modificacion de plan de procreacion responsable (fase GET)*/
    public function modifAction(Request $request, $idPlan)
    {
        $session = $request->getSession();      
        $repoPlanes = $this->get('repos_manager')->getPlanesProcreacionResponsableRepo();
        $plan = $repoPlanes->find($idPlan);
        if(!$plan)
        {
        	throw $this->createNotFoundException("Plan inexistente para el paciente");
        }
        $form = $this->createForm(new ModPlanProcRespType(), $plan);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaPlanBundle:PlanProcRespForm:modif.html.twig',
           			array('form' => $form->createView(),'id' => $idPlan,
           				  'rol' => $rolSeleccionado->getCodigo(),
           				  'nombreRol' => $rolSeleccionado->getNombre())
           		);
    }
    
    /*Modificacion de plan de procreacion responsable (fase POST)*/
    public function modifProcessAction(Request $request, $idPlan)
    {
    	$session = $request->getSession();
    	$repoPlanes = $this->get('repos_manager')->getPlanesProcreacionResponsableRepo();
    	$plan = $repoPlanes->find($idPlan);
    	if(!$plan)
    	{
    		throw $this->createNotFoundException("Plan inexistente para el paciente");
    	}
    	$form = $this->createForm(new ModPlanProcRespType(), $plan);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->get('persistence_manager')->updatePlanProcreacionResponsable($plan);
   			$mensaje = 'El plan del paciente se modifico exitosamente';
   			return $this->render(
   					'SalitaPlanBundle:PlanProcRespForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
   							'nombreRol' => $rolSeleccionado->getNombre())
   			);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar modificar un plan del paciente';
   			return $this->render(
   					'SalitaPlanBundle:PlanProcRespForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
   							'nombreRol' => $rolSeleccionado->getNombre())
   			);
   		}
    }

    function listAction(Request $request)
    {
        $session = $request->getSession();
        $repoPlanes = $this->get('repos_manager')->getPlanesProcreacionResponsableRepo();
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $planes = $repoPlanes->findAllById($session->get('paciente')->getId());
        return $this->render(
        			'SalitaPlanBundle:PlanProcRespForm:listado.html.twig',
        			array('planes' => $planes,'rol' => $rolSeleccionado->getCodigo(),
        				  'nombreRol' => $rolSeleccionado->getNombre())
        		);
    }

    function listDesAction(Request $request)
    {
        $session = $request->getSession();
        $repoPlanes = $this->get('repos_manager')->getPlanesProcreacionResponsableRepo();
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $planes = $repoPlanes->findAllByIdDes($session->get('paciente')->getId());
        return $this->render(
        			'SalitaPlanBundle:PlanProcRespForm:listadoDes.html.twig',
        			array('planes' => $planes,'rol' => $rolSeleccionado->getCodigo(),
        				  'nombreRol' => $rolSeleccionado->getNombre())
        		);
    }

    function habAction(Request $request, $idPlan)
    {
        $repoPlanes = $this->get('repos_manager')->getPlanesProcreacionResponsableRepo();
        $repoPlanes->habilitar($idPlan);
        return $this->redirect($this->generateUrl('listadoDes_planprocresp'));
    }

    function deshabAction(Request $request, $idPlan)
    {
        $repoPlanes = $this->get('repos_manager')->getPlanesProcreacionResponsableRepo();
        $repoPlanes->deshabilitar($idPlan);
        return $this->redirect($this->generateUrl('listado_planprocresp'));
    }
}