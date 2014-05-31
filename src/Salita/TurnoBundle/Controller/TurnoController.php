<?php
namespace Salita\TurnoBundle\Controller;
use Salita\TurnoBundle\Form\Type\TurnoType;
use Salita\TurnoBundle\Entity\Turno;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\FechaYHoraTurno;
use Salita\PacienteBundle\Form\Type\FechaYHoraTurnoType;
use Salita\OtrosBundle\Clases\ConsultaRol;

class TurnoController extends Controller
{

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $turno= new Turno();
        $form = $this->createForm(new TurnoType(), $turno);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);           
            if ($form->isValid())
            {
                $paciente = $session->get('paciente');
                $usuario = $session->get('usuario');
                $turno->setPaciente($paciente);
                $turno->setUsuario($usuario);
                $turno->setFecha(date("d-m-Y"));                
                $turno->setHora(date("H:i:s"));
                $turno->setAtendido(false);
                $em->persist($turno);
                $em->flush();
                return $this->render('SalitaTurnoBundle:TurnoForm:mensaje.html.twig', array('mensaje' => 'El turno para el paciente se agrego exitosamente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
            else 
            {
                return $this->render('SalitaTurnoBundle:TurnoForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar agregar un turno para el paciente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
            
        }
        else
        {
            return $this->render('SalitaTurnoBundle:TurnoForm:new.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
        }
    }

    public function newFuturoAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        if((!$session->has('fecha')) and (!$session->has('hora')))
        {
            return $this->redirect($this->generateUrl('seleccion_fecHor_futuro'));
        }
        $turno= new Turno();
        $form = $this->createForm(new TurnoType(),$turno);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);         
            if ($form->isValid())
            {
                $paciente = $session->get('paciente');
                $usuario = $session->get('usuario');
                $turno->setPaciente($paciente);
                $turno->setUsuario($usuario);
                $turno->setFecha($session->get('fecha'));                
                $turno->setHora($session->get('hora'));
                $session->remove('fecha');
                $session->remove('hora');
                $turno->setAtendido(false);
                $em->persist($turno);
                $em->flush();
                return $this->render('SalitaTurnoBundle:TurnoForm:mensaje.html.twig', array('mensaje' => 'El turno para el paciente se agrego exitosamente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
            else 
            {
                return $this->render('SalitaTurnoBundle:TurnoForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar agregar un turno para el paciente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
            
        }
        else
        {
            return $this->render('SalitaTurnoBundle:TurnoForm:newConFecHor.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
        }
    }

    public function seleccionarFecHorAction(Request $request)
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
           $fecHor = new FechaYHoraTurno();
           $form = $this->createForm(new FechaYHoraTurnoType(), $fecHor);
           if ($request->getMethod() == 'POST')
           {
               $form->bindRequest($request); 
               if ($form->isValid())
               {
                 $session->set('fecha', $fecHor->getFecha());
                 $session->set('hora', $fecHor->getHoraCompleta());
                 return $this->redirect($this->generateUrl('alta_turno_futuro'));
               }
           }
           else
           {
               return $this->render('SalitaTurnoBundle:SeleccionFechaHora:ingresoDatos.html.twig', array('form' => $form->createView(),'rol' =>  $rolSeleccionado->getCodigo(), 'nombreRol' => $rolSeleccionado->getNombre()));
           }
       }
    }

    public function atencionAction(Request $request, $idTurno)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repoTurnos = $em->getRepository('SalitaTurnoBundle:Turno');
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $turno = $repoTurnos->find($idTurno);
        $turno->setAtendido(true);
        $em->persist($turno);
        $em->flush();
        $session->set('paciente', $turno->getPaciente()); //esto ni idea por que lo hice... atento con eso...
        return $this->redirect($this->generateUrl('menu_paciente'));   
    }
}
