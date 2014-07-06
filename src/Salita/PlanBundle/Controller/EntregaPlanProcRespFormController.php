<?php
namespace Salita\PlanBundle\Controller;

use Salita\PlanBundle\Form\Type\EntregaPlanProcRespType;
use Salita\PlanBundle\Entity\EntregaPlanProcResp;
use Salita\OtrosBundle\Clases\MyController;

class EntregaPlanProcRespFormController extends MyController
{
	
	/*Alta de entrega de plan de procreacion responsable (fase GET)*/
 /*   public function newAction($idPlan)
    {
        $entrega = new EntregaPlanProcResp();
        $form = $this->createForm(new EntregaPlanProcRespType(), $entrega);
        return $this->render(
           			'SalitaPlanBundle:EntregaPlanProcRespForm:new.html.twig',
           			array('form' => $form->createView(), 'id' => $idPlan)
           		);
    }*/
    
    /*Alta de entrega de plan de procreacion responsable (fase POST)*/
    public function newAction($idPlan)
    {
    	$entrega = new EntregaPlanProcResp();
    	$form = $this->createForm(new EntregaPlanProcRespType(), $entrega);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
   			$plan = $repoPlanes->find($idPlan);
   			if(!$plan)
   			{
   				throw $this->createNotFoundException("Plan inexistente");
   			}
   			$this->getPersistenceManager()->saveEntregaPlanProcreacionResponsable($plan, $entrega);
   			$mensaje = 'La entrega del plan se registro correctamente';
   			$session = $this->getSession();
   			$session->set('mensaje', $mensaje);
   			return $this->redirect($this->generateUrl('resultado_operacion'));
   		}
   		return $this->render(
   					'SalitaPlanBundle:EntregaPlanProcRespForm:new.html.twig',
   					array('form' => $form->createView(), 'id' => $idPlan)
   				);
   	/*	return $this->render(
   				'SalitaPlanBundle:EntregaPlanProcRespForm:mensaje.html.twig',
   				array('mensaje' => $mensaje)
   		); */
    }

    function listAction($idPlan)
    {
        $repoPlanes = $this->getReposManager()->getEntregasPlanProcreacionResponsableRepo();
        $entregasplanprocresp = $repoPlanes->findAllOrderedByFecha($idPlan);
        return $this->render(
        			'SalitaPlanBundle:EntregaPlanProcRespForm:listado.html.twig', 
        			array('entregasplanprocresp' => $entregasplanprocresp)
        		);
    }
}