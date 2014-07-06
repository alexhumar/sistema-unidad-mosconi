<?php
namespace Salita\PacienteBundle\Controller;

use Salita\PacienteBundle\Form\Type\AntecedenteFamiliarType;
use Salita\PacienteBundle\Entity\AntecedenteFamiliar;
use Salita\OtrosBundle\Clases\MyController;

/* ATENCION: estos controllers no se referencian en ningun lado. */

class AntecedenteFamiliarFormController extends MyController
{

    public function newAction()
    {
        //$p = $this->getDoctrine()->getRepository('SalitaPacienteBundle:Paciente');
        //$paciente = $p->find($_SESSION['DNI']); denuevo... por que hice esto???
        //$session = $this->container->get('session');
        $session = $this->getSession();
        $paciente = $session->get('paciente');
        $antecedenteFamiliar = new AntecedenteFamiliar();
        $antecedenteFamiliar->setPaciente($paciente);
        $form = $this->createForm(new AntecedenteFamiliarType(), $antecedenteFamiliar);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);           
            if ($form->isValid())
            {
            	$em = $this->getEntityManager();
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
