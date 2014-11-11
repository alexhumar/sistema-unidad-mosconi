<?php
namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;

class InfoGralController extends MyController
{
	
    /*Pagina Acerca de*/
    public function acercaDeAction()
    {
   		return $this->render('SalitaOtrosBundle:InfoGral:acercaDe.html.twig');
    }
    
    /*Pagina Contacto*/
    public function contactoAction()
    {
    	return $this->render('SalitaOtrosBundle:InfoGral:contacto.html.twig');
    }
}