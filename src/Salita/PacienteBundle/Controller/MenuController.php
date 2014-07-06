<?php
namespace Salita\PacienteBundle\Controller;

use Salita\OtrosBundle\Clases\ConsultaEspecialidad;
use Salita\UsuarioBundle\Entity\Especialidad;
use Salita\OtrosBundle\Clases\MyController;

class MenuController extends MyController
{

    public function principalAction()
    {
       $session = $this->getSession();
       if(!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }    
       return $this->render('SalitaPacienteBundle:Menu:principal.html.twig');
    }
}