<?php
namespace Salita\PacienteBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Entity\AplicacionVacuna;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AplicacionVacunaFormController extends Controller
{

    public function newAction(Request $request)
    {
       //$session = $this->container->get('session');
       $session = $this->container->get('request')->getSession();
       if (!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {
           if (!$session->has('vacunaSeleccionada'))
           {
                return $this->redirect($this->generateUrl('busqueda_vacuna'));
           }
           else
           {    
                $em = $this->getDoctrine()->getEntityManager();
                $paciente = $session->get('paciente');
                $vacuna = $session->get('vacunaSeleccionada');
                $aplicacion = new AplicacionVacuna();
                $aplicacion->setFecha(date("d-m-Y"));
                $aplicacion->setPaciente($paciente);
                $aplicacion->setVacuna($vacuna);      
                $em->persist($aplicacion);
                $em->persist($paciente);
                $em->flush();
                $session->remove('vacunaSeleccionada');
           }
       }
       return $this->redirect($this->generateUrl('menu_paciente'));
    }

    public function listAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        if (!$session->has('paciente'))
        {
            return $this->redirect($this->generateUrl('busqueda_paciente'));
        }
        else
        {
            $em = $this->getDoctrine()->getEntityManager();
            $repoPacientes = $em->getRepository('SalitaPacienteBundle:Paciente');
            $rolSeleccionado = ConsultaRol::rolSeleccionado($session);           
            $aplicaciones = $repoPacientes->aplicacionesVacuna($session->get('paciente')->getId());
            return $this->render('SalitaPacienteBundle:AplicacionVacuna:list.html.twig', array('aplicaciones' => $aplicaciones,'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
        }
    }    
}
