<?php
namespace Salita\PlanBundle\Controller;

use Salita\PlanBundle\Form\Type\EntregaPlanProcRespType;
use Salita\PlanBundle\Entity\EntregaPlanProcResp;
use Salita\OtrosBundle\Clases\MyController;

class EntregaPlanProcRespFormController extends MyController
{
    
    /*Alta de entrega de plan de procreacion responsable*/
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
   			$translator = $this->getTranslator();
   			if(!$plan)
   			{
   				$mensaje = $this->getDialogsManager()->getPlanInexistenteMsg();
   				throw $this->createNotFoundException($translator->trans($mensaje));
   			}
   			$this->getPersistenceManager()->saveEntregaPlanProcreacionResponsable($plan, $entrega);
   			$mensaje = $this->getDialogsManager()->cargaEntregaPlanExitoMsg();
   			$session = $this->getSession();
   			$session->set('mensaje', $translator->trans($mensaje));
   			return $this->redirect($this->generateUrl('resultado_operacion_plan'));
   		}
   		return $this->render(
   					'SalitaPlanBundle:EntregaPlanProcRespForm:new.html.twig',
   					array('form' => $form->createView(), 'id' => $idPlan)
   				);
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