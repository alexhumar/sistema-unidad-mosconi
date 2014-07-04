<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\BarrioType;
use Salita\OtrosBundle\Entity\Barrio;
//use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;
use Salita\OtrosBundle\Service\ServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class BarrioFormController
{
	/*protected $request;
	protected $formfactory;
	protected $persistencemanager;
	protected $session;
	protected $httpkernel;
	protected $templating;
	protected $router;*/
	protected $serviceprovider;
	
	public function _construct(ServiceProvider $serviceprovider)
	{
		/*$this->request = $request;
		$this->formfactory = $formfactory;
		$this->persistencemanager = $persistencemanager;
		$this->session = $session;
		$this->httpkernel = $httpkernel;
		$this->templating = $templating;
		$this->router = $router;*/
		$this->serviceprovider = $serviceprovider;
	}

    /* Si no se submittearon datos del form al objeto barrio, handleRequest no hace nada y
     * el metodo isValid retorna false por lo que se genera el formulario
    * Por otro lado, si se submittearon datos no validos, isValid retorna false por lo que se
    * genera nuevamente el form pero ahora con los errores (recordar form_errors) de twig */
    
    /*Alta de barrio*/
    public function newAction()
    {
    	echo ("Hola1");
    	$barrio = new Barrio();
    	$form = $this->serviceprovider->getFormFactory()->create(new BarrioType(), $barrio);
    	//$request = $this->getRequest();
   		$form->handleRequest($this->serviceprovider->getRequest());
   		echo ("Hola2");
   		if ($form->isValid())
   		{
   			$this->serviceprovider->getPersistenceManager()->saveBarrio($barrio);
   			echo ("Hola3");
   			$mensaje = 'El barrio se cargo exitosamente en el sistema';
   			$session = $this->serviceprovider->getSession();
   			echo ("Hola4");
   			$session->getFlashBag()->add('mensaje', $mensaje);
   			$session->set('mensaje', $mensaje);
   			$nextAction = $form->get('guardarynuevo')->isClicked()
				? 'alta_barrio'
				: 'resultado_operacion';
   			echo ("Hola5");
   			return $this->serviceprovider->getHttpKernel()->redirect($this->serviceprovider->getRouter()->generate($nextAction));
   		}
   		die;
   		return $this->serviceprovider->getTemplating()->renderView(
   				'SalitaOtrosBundle:BarrioForm:new.html.twig',
   				array('form' => $form->createView())
   		);
    }
}