<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\AntecedenteFamiliarClinicoType;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarClinico;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AntecedenteFamiliarClinicoFormController extends Controller
{
   
    public function modifAction(Request $request)
    {   
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();   
        $repoAntecedentes = $em->getRepository('SalitaPacienteBundle:AntecedenteFamiliarClinico'); 
        $antecedenteFamiliarClinico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $form = $this->createForm(new AntecedenteFamiliarClinicoType(), $antecedenteFamiliarClinico);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);    
            if ($form->isValid())
            {
                $em->persist($antecedenteFamiliarClinico);
                $em->flush();
                return $this->render('SalitaPacienteBundle:AntecedenteFamiliarClinicoForm:mensaje.html.twig', array('mensaje' => 'Los antecedentes del paciente se modificaron exitosamente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
            else 
            {
                return $this->render('SalitaPacienteBundle:AntecedenteFamiliarClinicoForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al modificar los antecedentes del paciente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }  
        }
        else
        {
            return $this->render('SalitaPacienteBundle:AntecedenteFamiliarClinicoForm:modif.html.twig', array('form' => $form->createView(), 'rol' => $rolSeleccionado->getCodigo(), 'nombreRol' => $rolSeleccionado->getNombre(),
            ));
        }
    }
}
