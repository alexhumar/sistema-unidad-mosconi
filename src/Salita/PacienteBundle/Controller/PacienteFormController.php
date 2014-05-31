<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\DatosFiliatoriosType;
use Salita\PacienteBundle\Entity\Paciente;
use Salita\PacienteBundle\Entity\AntecedentePersonalClinico;
use Salita\PacienteBundle\Entity\AntecedentePersonalObstetrico;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarClinico;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarObstetrico;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class PacienteFormController extends Controller
{

    public function modificarDatosFiliatoriosAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $paciente = $session->get('paciente');
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $form = $this->createForm(new DatosFiliatoriosType(), $paciente);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);         
            if ($form->isValid())
            {
                $em->persist($paciente);
                $em->flush();
                return $this->render('SalitaPacienteBundle:PacienteForm:mensajeModificacion.html.twig', array('mensaje' => 'La modificacion del paciente se realizó con exito','rol' =>$rolSeleccionado->getCodigo(), 'nombreRol' =>$rolSeleccionado->getNombre(),));
            }
            else 
            {
                return $this->render('SalitaPacienteBundle:PacienteForm:mensajeModificacion.html.twig', array('mensaje' => 'Se produjo un error al intentar modificar los datos del paciente','rol' =>$rolSeleccionado->getCodigo(), 'nombreRol' =>$rolSeleccionado->getNombre(),));
            }
        }
        else
        {
            return $this->render('SalitaPacienteBundle:PacienteForm:datosFiliatorios.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(), 'nombreRol' => $rolSeleccionado->getNombre(),
            ));
        }
    }


    public function newAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $paciente = new Paciente();
        $form = $this->createForm(new DatosFiliatoriosType(), $paciente);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);          
            if ($form->isValid())
            {           
                $antecedentePersonalObstetrico = new AntecedentePersonalObstetrico();
                $antecedentePersonalObstetrico->setPaciente($paciente);
                $antecedenteFamiliarObstetrico = new AntecedenteFamiliarObstetrico();
                $antecedenteFamiliarObstetrico->setPaciente($paciente);
                //$em->persist($antecedentePersonalObstetrico);
                //$em->persist($antecedenteFamiliarObstetrico);
                $antecedentePersonalClinico = new AntecedentePersonalClinico();
                $antecedentePersonalClinico->setPaciente($paciente);
                $antecedenteFamiliarClinico = new AntecedenteFamiliarClinico();
                $antecedenteFamiliarClinico->setPaciente($paciente);         
                //$em->persist($antecedentePersonalClinico);
                //$em->persist($antecedenteFamiliarClinico);
                $em->persist($paciente);
                $em->flush();
                return $this->render('SalitaPacienteBundle:PacienteForm:mensajeAlta.html.twig', array('mensaje' => 'El paciente se cargo exitosamente en el sistema','rol' => $rolSeleccionado->getCodigo(),));
            }
            else 
            {
                return $this->render('SalitaPacienteBundle:PacienteForm:mensajeAlta.html.twig', array('mensaje' => 'Se produjo un error al intentar cargar el paciente al sistema','rol' => $rolSeleccionado->getCodigo(),));
            }
        }
        else
        {
            return $this->render('SalitaPacienteBundle:PacienteForm:new.html.twig', array('form' => $form->createView(), 'rol' => $rolSeleccionado->getCodigo(),
            ));
        }
    }
}
