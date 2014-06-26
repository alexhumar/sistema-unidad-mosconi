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
        $session = $this->getSession();
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
    public function newProcessAction()
    {
    	$session = $this->getSession();
    	$plan = new PlanProcResp();
    	$form = $this->createForm(new PlanProcRespType(), $plan);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$paciente = $session->get('paciente');
   			$this->getPersistenceManager()->savePlanProcreacionResponsable($plan, $paciente);
   			$mensaje = 'El plan del paciente se agrego  exitosamente';
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar agregar un plan para el paciente';
		}
		return $this->render(
				'SalitaPlanBundle:PlanProcRespForm:mensaje.html.twig',
				array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
						'nombreRol' => $rolSeleccionado->getNombre())
		);
    }

    /*Modificacion de plan de procreacion responsable (fase GET)*/
    public function modifAction($idPlan)
    {
        $session = $this->getSession();      
        $repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
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
    public function modifProcessAction($idPlan)
    {
    	$session = $this->getSession();
    	$repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
    	$plan = $repoPlanes->find($idPlan);
    	if(!$plan)
    	{
    		throw $this->createNotFoundException("Plan inexistente para el paciente");
    	}
    	$form = $this->createForm(new ModPlanProcRespType(), $plan);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
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
   				array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo(),
   						'nombreRol' => $rolSeleccionado->getNombre())
   		);
    }

    function listAction()
    {
        $session = $this->getSession();
        $repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $planes = $repoPlanes->findAllById($session->get('paciente')->getId());
        return $this->render(
        			'SalitaPlanBundle:PlanProcRespForm:listado.html.twig',
        			array('planes' => $planes,'rol' => $rolSeleccionado->getCodigo(),
        				  'nombreRol' => $rolSeleccionado->getNombre())
        		);
    }

    function listDesAction()
    {
        $session = $this->getSession();
        $repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $planes = $repoPlanes->findAllByIdDes($session->get('paciente')->getId());
        return $this->render(
        			'SalitaPlanBundle:PlanProcRespForm:listadoDes.html.twig',
        			array('planes' => $planes,'rol' => $rolSeleccionado->getCodigo(),
        				  'nombreRol' => $rolSeleccionado->getNombre())
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