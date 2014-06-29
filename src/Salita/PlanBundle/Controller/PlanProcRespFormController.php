<?php
namespace Salita\PlanBundle\Controller;

use Salita\PlanBundle\Form\Type\PlanProcRespType;
use Salita\PlanBundle\Form\Type\ModPlanProcRespType;
use Salita\PlanBundle\Entity\PlanProcResp;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class PlanProcRespFormController extends MyController
{

	/*Alta de plan de procreacion responsable (fase GET)*/
    public function newAction()
    {
        $plan = new PlanProcResp();
        $form = $this->createForm(new PlanProcRespType(), $plan);
        return $this->render(
           			'SalitaPlanBundle:PlanProcRespForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
    
    /*Alta de plan de procreacion responsable (fase POST)*/
    public function newProcessAction()
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
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar agregar un plan para el paciente';
		}
		return $this->render(
				'SalitaPlanBundle:PlanProcRespForm:mensaje.html.twig',
				array('mensaje' => $mensaje)
		);
    }

    /*Modificacion de plan de procreacion responsable (fase GET)*/
    public function modifAction($idPlan)
    {    
        $repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
        $plan = $repoPlanes->find($idPlan);
        if(!$plan)
        {
        	throw $this->createNotFoundException("Plan inexistente para el paciente");
        }
        $form = $this->createForm(new ModPlanProcRespType(), $plan);
        return $this->render(
           			'SalitaPlanBundle:PlanProcRespForm:modif.html.twig',
           			array('form' => $form->createView(),'id' => $idPlan)
           		);
    }
    
    /*Modificacion de plan de procreacion responsable (fase POST)*/
    public function modifProcessAction($idPlan)
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
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar modificar un plan del paciente';
   		}
   		return $this->render(
   				'SalitaPlanBundle:PlanProcRespForm:mensaje.html.twig',
   				array('mensaje' => $mensaje)
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