<?php
namespace Salita\PacienteBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;
use Salita\OtrosBundle\Clases\ConsultaEspecialidad;

class MenuController extends Controller
{

    public function principalAction(Request $request)
    {
       //$session = $this->container->get('session');
       $session = $this->container->get('request')->getSession();
       if(!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {
           $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
           if ($rolSeleccionado->getCodigo() == 'ROLE_MEDICO')
           {
               $especialidad = ConsultaEspecialidad::especialidadSeleccionada();
               $codigoEspecialidad = $especialidad->getCodigo();
           }
           else 
           {
               $codigoEspecialidad = 'NO TIENE';
           }
           $paciente = $session->get('paciente');

           return $this->render('SalitaPacienteBundle:Menu:principal.html.twig', array('paciente' => $paciente, 'rol' =>$rolSeleccionado->getCodigo(), 'nombreRol' =>$rolSeleccionado->getNombre(),'especialidad' => $codigoEspecialidad,));
       }
    }
}
