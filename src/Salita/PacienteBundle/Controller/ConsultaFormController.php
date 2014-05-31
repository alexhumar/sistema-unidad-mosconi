<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\ConsultaType;
use Salita\PacienteBundle\Entity\Consulta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class ConsultaFormController extends Controller
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
           if (!$session->has('diagnosticoSeleccionado'))
           {
                return $this->redirect($this->generateUrl('busqueda_diagnostico'));
           }
           else
           {
                $em = $this->getDoctrine()->getEntityManager();
                $consulta = new Consulta();
                $form = $this->createForm(new ConsultaType(), $consulta);
                $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
                if ($request->getMethod() == 'POST')
                {
                    $form->bindRequest($request);
                    if ($form->isValid())
                    {
                        $paciente = $session->get('paciente');
                        $usuario = $session->get('usuario');
                        $diagnostico = $session->get('diagnosticoSeleccionado');
                        $consulta->setPaciente($paciente);
                        $consulta->setUsuario($usuario);
                        $consulta->setDiagnostico($diagnostico);
                        $consulta->setFecha(date("d-m-Y"));
                        $consulta->setHora(date("H:i:s"));
                        $em->persist($consulta);
                        $em->flush();
                        $session->remove('diagnosticoSeleccionado');
                        return $this->redirect($this->generateUrl('menu_paciente'));
                    }
                    else
                    {
                        return $this->render('SalitaPacienteBundle:ConsultaForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al cargar la consulta en el sistema',));
                    }
                }
                else
                {
                     return $this->render('SalitaPacienteBundle:ConsultaForm:new.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
                } 
           }
       }
    }
}
