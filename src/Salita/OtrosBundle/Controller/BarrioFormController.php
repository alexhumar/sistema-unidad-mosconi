<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\BarrioType;
use Salita\OtrosBundle\Entity\Barrio;
//use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class BarrioFormController
{
	protected $request;
	protected $formfactory;
	protected $persistencemanager;
	protected $session;
	protected $httpkernel;
	protected $templating;
	protected $router;
	
	public function _construct($request, $formfactory, $persistencemanager, 
			                   $session, $httpkernel, $templating, $router)
	{
		$this->request = $request;
		$this->formfactory = $formfactory;
		$this->persistencemanager = $persistencemanager;
		$this->session = $session;
		$this->httpkernel = $httpkernel;
		$this->templating = $templating;
		$this->router = $router;
	}

    /* Si no se submittearon datos del form al objeto barrio, handleRequest no hace nada y
     * el metodo isValid retorna false por lo que se genera el formulario
    * Por otro lado, si se submittearon datos no validos, isValid retorna false por lo que se
    * genera nuevamente el form pero ahora con los errores (recordar form_errors) de twig */
    
    /*Alta de barrio*/
    public function newAction()
    {
    	$barrio = new Barrio();
    	$form = $this->formfactory->create(new BarrioType(), $barrio);
    	//$request = $this->getRequest();
   		$form->handleRequest($this->$request);
   		if ($form->isValid())
   		{
   			$this->persistencemanager->saveBarrio($barrio);
   			$mensaje = 'El barrio se cargo exitosamente en el sistema';
   			$session = $this->session;
   			$session->getFlashBag()->add('mensaje', $mensaje);
   			$session->set('mensaje', $mensaje);
   			$nextAction = $form->get('guardarynuevo')->isClicked()
				? 'alta_barrio'
				: 'resultado_operacion';
   			return $this->httpkernel->redirect($this->route->generate($nextAction));
   		}
   		return $this->templating->renderView(
   				'SalitaOtrosBundle:BarrioForm:new.html.twig',
   				array('form' => $form->createView())
   		);
    }
}