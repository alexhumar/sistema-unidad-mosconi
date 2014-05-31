<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\AntecedentePersonalType;
use Salita\PacienteBundle\Entity\AntecedentePersonal;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AntecedentePersonalFormController extends Controller
{

    public function newAction(Request $request)
    {
        //$p = $this->getDoctrine()->getRepository('SalitaPacienteBundle:Paciente');
        //$paciente = $p->find($_SESSION['DNI']); por que estaba asi esto que comente????
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $paciente = $session->get('paciente');      
        $antecedentePersonal= new AntecedentePersonal();
        $antecedentePersonal->setPaciente($paciente);
        $form = $this->createForm(new AntecedentePersonalType(), $antecedentePersonal);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);         
            if ($form->isValid())
            {             
                $em->persist($antecedentePersonal);
                $em->flush();
                return $this->render('SalitaPacienteBundle:AntecedentePersonalForm:mensaje.html.twig', array('mensaje' => 'Los antecedentes personales se cargaron exitosamente en el sistema',
            ));
            }
            else 
            {
                return $this->render('SalitaPacienteBundle:AntecedentePersonalForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar cargar los antecedentes personales en el sistema',
            ));
            }
        }
        else
        {
            return $this->render('SalitaPacienteBundle:AntecedentePersonalForm:new.html.twig', array('form' => $form->createView(),
            ));
        }
    }
    
    public function modifAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repoAntecedentes = $em->getRepository('SalitaPacienteBundle:AntecedentePersonal');
        $antecedentePersonal = $repoAntecedentes->find($id);
        $form = $this->createForm(new AntecedentePersonalType(), $antecedentePersonal);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);        
            if ($form->isValid())
            {
                $em->persist($antecedentePersonal);
                $em->flush();
                return $this->render('SalitaPacienteBundle:AntecedentePersonalForm:mensaje.html.twig', array('mensaje' => 'Los antecedentes personales se modificaron exitosamente',
            ));
            }
            else 
            {
                return $this->render('SalitaPacienteBundle:AntecedentePersonalForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar modificar los antecedentes personales',
            ));
            }
            
        }
        else
        {
            return $this->render('SalitaPacienteBundle:AntecedentePersonalForm:modif.html.twig', array('form' => $form->createView(),'id' => $id,
            ));
        }
    }
}
