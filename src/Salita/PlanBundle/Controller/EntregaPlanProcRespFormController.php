<?php
namespace Salita\PlanBundle\Controller;
use Salita\PlanBundle\Form\Type\EntregaPlanProcRespType;
use Salita\PlanBundle\Entity\EntregaPlanProcResp;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class EntregaPlanProcRespFormController extends Controller
{
	
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function getPlanesProcreacionResponsableRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPlanBundle:PlanProcResp');
	}
	
	private function guardarEntregaPlanProcreacionResponsable($plan, $entrega)
	{
		$entrega->setFecha(date("d-m-Y"));
		$entrega->setPlan($plan);
		$em = $this->getEntityManager();
		/*Como el plan se obtuvo del repo, esta "seguido" por doctrine. Como la entrega se asocia al plan
		 * el persist no haria falta ya que la entrega deberia almacenarse gracias a la persistencia en cascada*/
		//$em->persist($entrega);
		$em->flush();
	}

	/*Alta de entrega de plan de procreacion responsable (fase GET)*/
    public function newAction(Request $request, $idPlan)
    {
        $session = $request->getSession();
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
    public function newProcessAction(Request $request, $idPlan)
    {
    	$session = $request->getSession();
    	$entrega = new EntregaPlanProcResp();
    	$form = $this->createForm(new EntregaPlanProcRespType(), $entrega);
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$repoPlanes = $this->getPlanesProcreacionResponsableRepo();
   			$plan = $repoPlanes->find($idPlan);
   			if(!$plan)
   			{
   				throw $this->createNotFoundException("Plan inexistente");
   			}
   			$this->guardarEntregaPlanProcreacionResponsable($plan, $entrega);
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

    function listAction(Request $request, $idPlan)
    {
        $session = $request->getSession();
        $repoPlanes = $this->getPlanesProcreacionResponsableRepo();
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
