<?php
namespace Salita\PlanBundle\Controller;

use Salita\PlanBundle\Form\Type\EntregaPlanProcRespType;
use Salita\PlanBundle\Entity\EntregaPlanProcResp;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class EntregaPlanProcRespFormController extends MyController
{
	
	/*Alta de entrega de plan de procreacion responsable (fase GET)*/
    public function newAction($idPlan)
    {
        $session = $this->getSession();
        $entrega = new EntregaPlanProcResp();
        $form = $this->createForm(new EntregaPlanProcRespType(), $entrega);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        return $this->render(
           			'SalitaPlanBundle:EntregaPlanProcRespForm:new.html.twig',
           			array('form' => $form->createView(), 'id' => $idPlan,
           				  'rol' => $rolSeleccionado->getCodigo(),
           				  'nombreRol' => $rolSeleccionado->getNombre())
           		);
    }
    
    /*Alta de entrega de plan de procreacion responsable (fase POST)*/
    public function newProcessAction($idPlan)
    {
    	$session = $this->getSession();
    	$entrega = new EntregaPlanProcResp();
    	$form = $this->createForm(new EntregaPlanProcRespType(), $entrega);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
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
   			return $this->render(
   					'SalitaPlanBundle:EntregaPlanProcRespForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
   			);
   		}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar registrar una entrega del plan';
   			return $this->render(
   					'SalitaPlanBundle:EntregaPlanProcRespForm:mensaje.html.twig',
   					array('mensaje' => $mensaje,'rol' => $rolSeleccionado->getCodigo())
   			);
   		}
    }

    function listAction($idPlan)
    {
        $session = $this->getSession();
        $repoPlanes = $this->getReposManager()->getPlanesProcreacionResponsableRepo();
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $entregasplanprocresp = $repoPlanes->encontrarTodosOrdenadosPorFecha($idPlan);
        return $this->render(
        			'SalitaPlanBundle:EntregaPlanProcRespForm:listado.html.twig', 
        			array('entregasplanprocresp' => $entregasplanprocresp,
        				  'rol' => $rolSeleccionado->getCodigo(),
        				  'nombreRol' => $rolSeleccionado->getNombre())
        		);
    }
}