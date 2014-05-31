<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\EstudioType;
use Salita\PacienteBundle\Entity\Estudio;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class EstudioFormController extends Controller
{

    public function newAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $estudio = new Estudio();
        $form = $this->createForm(new EstudioType(), $estudio);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            if ($form->isValid())
            {           
                $paciente = $session->get('paciente');
                $usuario = $session->get('usuario'); 
                $estudio->setPaciente($paciente);
                $estudio->setUsuario($usuario);
                $estudio->setFecha(date("d-m-Y"));                
                $estudio->setHora(date("H:i:s"));
                $em->persist($estudio);
                $em->flush();
                return $this->render('SalitaPacienteBundle:EstudioForm:mensaje.html.twig', array('mensaje' => 'El estudio del paciente se cargo exitosamente en el sistema','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
            else 
            {
                return $this->render('SalitaPacienteBundle:EstudioForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar cargar un estudio para el paciente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }  
        }
        else
        {
            return $this->render('SalitaPacienteBundle:EstudioForm:new.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),
            ));
        }
    }
}
