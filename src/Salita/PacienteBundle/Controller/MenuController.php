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
       /* Si a la hora de registrar "otras anotaciones" (al registrar una consulta) voy al menu 
        * principal por ejemplo, cuando vuelvo al proceso de registro de consulta me lleva directamente
        * a otras anotaciones (por como esta hecho el controller), ya sea que el paciente seleccionado sea
        * el mismo con el que seleccione el diagnostico u otro. No queda bien. */
       $session->remove('diagnosticoSeleccionado');
       if(!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }    
       return $this->render('SalitaPacienteBundle:Menu:principal.html.twig');
    }
}