<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\BarrioType;
use Salita\OtrosBundle\Entity\Barrio;
//use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;
use Salita\OtrosBundle\Service\ServiceProvider;

class BarrioFormController
{
	
	protected $serviceprovider;
	
	public function __construct(ServiceProvider $serviceprovider)
	{
		$this->serviceprovider = $serviceprovider;
	}

    /* Si no se submittearon datos del form al objeto barrio, handleRequest no hace nada y
     * el metodo isValid retorna false por lo que se genera el formulario
    * Por otro lado, si se submittearon datos no validos, isValid retorna false por lo que se
    * genera nuevamente el form pero ahora con los errores (recordar form_errors) de twig */
    
    /*Alta de barrio*/
    public function newAction()
    {
    	$barrio = new Barrio();
    	echo("Hola");
    	echo(var_dump($this->serviceprovider));die;
    	$form = $this->serviceprovider->getFormFactory()->create(new BarrioType(), $barrio);
    	//$request = $this->getRequest();
   		$form->handleRequest($this->serviceprovider->getRequest());
   		if ($form->isValid())
   		{
   			$this->serviceprovider->getPersistenceManager()->saveBarrio($barrio);
   			$mensaje = 'El barrio se cargo exitosamente en el sistema';
   			$session = $this->serviceprovider->getSession();
   			$session->getFlashBag()->add('mensaje', $mensaje);
   			$session->set('mensaje', $mensaje);
   			$nextAction = $form->get('guardarynuevo')->isClicked()
				? 'alta_barrio'
				: 'resultado_operacion';
   			return $this->serviceprovider->getHttpKernel()->redirect($this->serviceprovider->getRouter()->generate($nextAction));
   		}
   		die;
   		return $this->serviceprovider->getTemplating()->renderView(
   				'SalitaOtrosBundle:BarrioForm:new.html.twig',
   				array('form' => $form->createView())
   		);
    }
}