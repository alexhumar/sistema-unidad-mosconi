<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\AntecedenteFamiliarObstetricoType;
use Salita\PacienteBundle\Entity\AntecedenteFamiliarObstetrico;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AntecedenteFamiliarObstetricoFormController extends Controller
{
    
    public function modifAction(Request $request)
    {      
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repoAntecedentes = $this->getDoctrine()->getRepository('SalitaPacienteBundle:AntecedenteFamiliarObstetrico');
        $antecedenteFamiliarObstetrico = $repAntecedente->buscarAntecedenteDePaciente($session->get('paciente')->getId());
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $form = $this->createForm(new AntecedenteFamiliarObstetricoType(), $antecedenteFamiliarObstetrico);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);           
            if ($form->isValid())
            {
                $em->persist($antecedenteFamiliarObstetrico);
                $em->flush();
                return $this->render('SalitaPacienteBundle:AntecedenteFamiliarObstetricoForm:mensaje.html.twig', array('mensaje' => 'Los antecedentes del paciente se modificaron exitosamente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
            else 
            {
                return $this->render('SalitaPacienteBundle:AntecedenteFamiliarObstetricoForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al modificar los antecedentes del paciente','rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }  
        }
        else
        {
            return $this->render('SalitaPacienteBundle:AntecedenteFamiliarObstetricoForm:modif.html.twig', array('form' => $form->createView(), 'rol' => $rolSeleccionado->getCodigo(), 'nombreRol' => $rolSeleccionado->getNombre(),
            ));
        }
    }
}
