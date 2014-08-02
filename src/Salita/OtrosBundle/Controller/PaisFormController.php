<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\PaisType;
use Salita\OtrosBundle\Entity\Pais;
use Salita\OtrosBundle\Clases\MyController;

class PaisFormController extends MyController
{
	/*ATENCION: NO HAY RUTA QUE REFERENCIE ESTE CONTROLADOR.*/
    
    /*Alta de pais*/
    public function newAction()
    {
    	$pais = new Pais();
    	$form = $this->createForm(new PaisType(), $pais);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$this->getPersistenceManager()->savePais($pais);
   			$mensaje = $this->getDialogsManager()->cargaPaisExitoMsg();
   			$translator = $this->getTranslator();
   			$session = $this->getSession();
   			$session->set('mensaje', $translator->trans($mensaje));
   			$session->getFlashBag()->add('mensaje', $translator->trans($mensaje));
   			$nextAction = $form->get('guardarynuevo')->isClicked()
   				? 'alta_pais'
   				: 'resultado_operacion';
   			return $this->redirect($this->generateUrl($nextAction));
   		}
        return $this->render(
           			'SalitaOtrosBundle:PaisForm:new.html.twig',
           			array('form' => $form->createView())
           		);
    }
}