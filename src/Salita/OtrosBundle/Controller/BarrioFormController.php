<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\BarrioType;
use Salita\OtrosBundle\Entity\Barrio;
use Salita\OtrosBundle\Service\ServiceProvider;
use Salita\OtrosBundle\Clases\ConsultaRol;
use Symfony\Component\HttpFoundation\RedirectResponse;

/* Controller definido como servico, como para contar con un ejemplo funcional. Ver ademas los archivos
 * routing.yml, service.yml y el servicio Salita\OtrosBundle\Service\ServiceProvider */
class BarrioFormController
{

	protected $serviceprovider;
	
	public function __construct(ServiceProvider $serviceprovider)
	{
		$this->serviceprovider = $serviceprovider;
	}
    
    /*Alta de barrio*/
    public function newAction()
    {
    	/* Si no se submittearon datos del form al objeto barrio, handleRequest no hace nada y
    	 * el metodo isValid retorna false por lo que se genera el formulario
    	* Por otro lado, si se submittearon datos no validos, isValid retorna false por lo que se
    	* genera nuevamente el form pero ahora con los errores (recordar form_errors) de twig */
    	$barrio = new Barrio();
    	$form = $this->serviceprovider->getFormFactory()->create(new BarrioType(), $barrio);
   		$form->handleRequest($this->serviceprovider->getRequest());
   		if ($form->isValid())
   		{
   			$this->serviceprovider->getPersistenceManager()->saveBarrio($barrio);
   			$mensaje = 'El barrio se cargo exitosamente en el sistema';
   			/*$session = $this->serviceprovider->getSession();
   			$session->getFlashBag()->add('mensaje', $mensaje);
   			$session->set('mensaje', $mensaje);*/
   			$sessionManager = $this->serviceprovider->getSessionManager();
   			$nextAction = $form->get('guardarynuevo')->isClicked()
				? 'alta_barrio'
				: 'resultado_operacion';
   			echo("Hola1");
   			$sessionManager->setMensajeResultadoOperacion($nextAction, $mensaje);
   			echo("hola2");
   			/*Las redirecciones en servicios se hacen directamente mediante el objeto RedirectResponse*/
   			return new RedirectResponse($this->serviceprovider->getRouter()->generate($nextAction));
   		}
   		return $this->serviceprovider->getTemplating()->renderResponse(
   				'SalitaOtrosBundle:BarrioForm:new.html.twig',
   				array('form' => $form->createView())
   		);
    }
}