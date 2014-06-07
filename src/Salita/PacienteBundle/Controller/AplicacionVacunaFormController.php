<?php
namespace Salita\PacienteBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Entity\AplicacionVacuna;
use Salita\OtrosBundle\Clases\ConsultaRol;

class AplicacionVacunaFormController extends Controller
{
	private function getEntityManager()
	{
		return $this->getDoctrine()->getManager();
	}
	
	private function getPacientesRepo()
	{
		$em = $this->getEntityManager();
		return $em->getRepository('SalitaPacienteBundle:Paciente');
	}
	
	private function crearAplicacionVacuna($paciente, $vacuna)
	{
		$aplicacion = new AplicacionVacuna();
		$aplicacion->setFecha(date("d-m-Y"));
		$aplicacion->setPaciente($paciente);
		$aplicacion->setVacuna($vacuna);
		$em = $this->getEntityManager();
		$em->persist($aplicacion);
		/*Me parece que el persist de paciente no hace falta*/
		$em->persist($paciente);
		$em->flush();
	}

    public function newAction(Request $request)
    {
       $session = $request->getSession();
       if (!$session->has('paciente'))
       {
           return $this->redirect($this->generateUrl('busqueda_paciente'));
       }
       else
       {
           if (!$session->has('vacunaSeleccionada'))
           {
                return $this->redirect($this->generateUrl('busqueda_vacuna'));
           }
           else
           {    
                $paciente = $session->get('paciente');
                $vacuna = $session->get('vacunaSeleccionada');
                $this->crearAplicacionVacuna($paciente, $vacuna);
                $session->remove('vacunaSeleccionada');
           }
       }
       return $this->redirect($this->generateUrl('menu_paciente'));
    }

    public function listAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('paciente'))
        {
            return $this->redirect($this->generateUrl('busqueda_paciente'));
        }
        else
        {
            $repoPacientes = $this->getPacientesRepo();           
            $aplicaciones = $repoPacientes->aplicacionesVacuna($session->get('paciente')->getId());
            $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
            return $this->render(
            			'SalitaPacienteBundle:AplicacionVacuna:list.html.twig',
            			array('aplicaciones' => $aplicaciones,'rol' => $rolSeleccionado->getCodigo(),
            				  'nombreRol' => $rolSeleccionado->getNombre())
            		);
        }
    }    
}
