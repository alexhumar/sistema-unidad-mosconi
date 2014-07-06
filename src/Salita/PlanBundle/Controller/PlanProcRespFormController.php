<?php
namespace Salita\PlanBundle\Controller;

use Salita\PlanBundle\Form\Type\PlanProcRespType;
use Salita\PlanBundle\Form\Type\ModPlanProcRespType;
use Salita\PlanBundle\Entity\PlanProcResp;
use Salita\OtrosBundle\Clases\MyController;

class PlanProcRespFormController extends MyController
{
    
    /*Alta de plan de procreacion responsable*/
    public function newAction()
    {
    	$plan = new PlanProcResp();
    	$form = $this->createForm(new PlanProcRespType(), $plan);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$session = $this->getSession();
   			$paciente = $session->get('paciente');
   			$this->getPersistenceManager()->savePlanProcreacionResponsable($plan, $paciente);
   			$mensaje = 'El plan del paciente se agrego exitosamente';
   			$session = $this->getSession();
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion_plan'));
   		}
   		return $this->render(
   					'SalitaPlanBundle:PlanProcRespForm:new.html.twig',
   					array('form' => $form->createView())
   				);
    }
    
    /*Modificacion de plan de procreacion responsable*/
    public function modifAction($idPlan)
    {
    	$repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
    	$plan = $repoPlanes->find($idPlan);
    	if(!$plan)
    	{
    		throw $this->createNotFoundException("Plan inexistente para el paciente");
    	}
    	$form = $this->createForm(new ModPlanProcRespType(), $plan);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->updatePlanProcreacionResponsable($plan);
   			$mensaje = 'El plan del paciente se modifico exitosamente';
   			$session = $this->getSession();
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion_plan'));
   		}
   		return $this->render(
           			'SalitaPlanBundle:PlanProcRespForm:modif.html.twig',
           			array('form' => $form->createView(),'id' => $idPlan)
           		);
    }

    function listAction()
    {
        $session = $this->getSession();
        $repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
        $planes = $repoPlanes->findAllById($session->get('paciente')->getId());
        return $this->render(
        			'SalitaPlanBundle:PlanProcRespForm:listado.html.twig',
        			array('planes' => $planes)
        		);
    }

    function listDesAction()
    {
        $session = $this->getSession();
        $repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
        $planes = $repoPlanes->findAllByIdDes($session->get('paciente')->getId());
        return $this->render(
        			'SalitaPlanBundle:PlanProcRespForm:listadoDes.html.twig',
        			array('planes' => $planes)
        		);
    }

    function habAction($idPlan)
    {
        $repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
        $repoPlanes->habilitar($idPlan);
        return $this->redirect($this->generateUrl('listadoDes_planprocresp'));
    }

    function deshabAction($idPlan)
    {
        $repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
        $repoPlanes->deshabilitar($idPlan);
        return $this->redirect($this->generateUrl('listado_planprocresp'));
    }
}