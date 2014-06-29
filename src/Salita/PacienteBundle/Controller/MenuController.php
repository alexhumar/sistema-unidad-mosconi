<?php
namespace Salita\PacienteBundle\Controller;

use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;
use Salita\OtrosBundle\Clases\ConsultaEspecialidad;
use Salita\UsuarioBundle\Entity\Especialidad;

class MenuController extends MyController
{

    public function principalAction()
    {
       $session = $this->getSession();
       if(!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {
          /* $rolSeleccionado = ConsultaRol::rolSeleccionado($session); 
           if ($rolSeleccionado->isRoleMedico())
           { 	   
               $especialidad = ConsultaEspecialidad::especialidadSeleccionada($session);
               $codigoEspecialidad = $especialidad->getCodigo();
           }
           else 
           {
               //$codigoEspecialidad = 'NO_TIENE';
               $codigoEspecialidad = Especialidad::getCodigoNoTieneEspecialidad();
           }
           //$paciente = $session->get('paciente');*/
           return $this->render('SalitaPacienteBundle:Menu:principal.html.twig');
       }
    }
}