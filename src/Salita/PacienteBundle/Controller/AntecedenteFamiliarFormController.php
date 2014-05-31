<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\AntecedenteFamiliarType;
use Salita\PacienteBundle\Entity\AntecedenteFamiliar;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AntecedenteFamiliarFormController extends Controller
{

    public function newAction(Request $request)
    {
        //$p = $this->getDoctrine()->getRepository('SalitaPacienteBundle:Paciente');
        //$paciente = $p->find($_SESSION['DNI']); denuevo... por que hice esto???
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $paciente = $session->get('paciente');
        $antecedenteFamiliar= new AntecedenteFamiliar();
        $antecedenteFamiliar->setPaciente($paciente);
        $form = $this->createForm(new AntecedenteFamiliarType(), $antecedenteFamiliar);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);           
            if ($form->isValid())
            {
                $em->persist($antecedenteFamiliar);
                $em->flush();
                return $this->render('SalitaPacienteBundle:AntecedenteFamiliarForm:mensaje.html.twig', array('mensaje' => 'Los antecedentes familiares fueron creados exitosamente',
            ));
            }
            else 
            {
                return $this->render('SalitaPacienteBundle:AntecedenteFamiliarForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar crear los antecedentes familiares',
            ));
            }   
        }
        else
        {
            return $this->render('SalitaPacienteBundle:AntecedenteFamiliarForm:new.html.twig', array('form' => $form->createView(),
            ));
        }
    }
    
    public function modifAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repoAntecedentes = $em->getRepository('SalitaPacienteBundle:AntecedenteFamiliar');
        $antecedenteFamiliar = $repoAntecedentes->find($id);
        $form = $this->createForm(new AntecedenteFamiliarType(), $antecedenteFamiliar);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);          
            if ($form->isValid())
            {
                $em->persist($antecedenteFamiliar);
                $em->flush();
                return $this->render('SalitaPacienteBundle:AntecedenteFamiliarForm:mensaje.html.twig', array('mensaje' => 'Los antecedentes familiares fueron modificados exitosamente',
            ));
            }
            else 
            {
                return $this->render('SalitaPacienteBundle:AntecedenteFamiliarForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar modificar los antecedentes familiares',
            ));
            }
            
        }
        else
        {
            return $this->render('SalitaPacienteBundle:AntecedenteFamiliarForm:modif.html.twig', array('form' => $form->createView(),'id' => $id,
            ));
        }
    }
}
