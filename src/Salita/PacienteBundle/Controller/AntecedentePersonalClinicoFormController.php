<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\AntecedentePersonalClinicoType;
use Salita\PacienteBundle\Entity\AntecedentePersonalClinico;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AntecedentePersonalClinicoFormController extends Controller
{

    public function modifAction(Request $request)
    {        
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repoAntecedentes = $em->getRepository('SalitaPacienteBundle:AntecedentePersonalClinico');
        $antecedentePersonalClinico = $repoAntecedentes->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $form = $this->createForm(new AntecedentePersonalClinicoType(), $antecedentePersonalClinico);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);         
            if ($form->isValid())
            {
                $em->persist($antecedentePersonalClinico);
                $em->flush();
                return $this->render('SalitaPacienteBundle:AntecedentePersonalClinicoForm:mensaje.html.twig', array('mensaje' => 'Los antecedentes del paciente se modificaron exitosamente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
            else 
            {
                return $this->render('SalitaPacienteBundle:AntecedentePersonalClinicoForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al modificar los antecedentes del paciente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }  
        }
        else
        {
            return $this->render('SalitaPacienteBundle:AntecedentePersonalClinicoForm:modif.html.twig', array('form' => $form->createView(), 'rol' => $rolSeleccionado->getCodigo(), 'nombreRol' => $rolSeleccionado->getNombre(),
            ));
        }
    }
}
