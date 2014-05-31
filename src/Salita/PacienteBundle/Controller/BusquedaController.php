<?php
namespace Salita\PacienteBundle\Controller;
use Salita\PacienteBundle\Form\Type\BusquedaType;
use Salita\PacienteBundle\Clases\Busqueda;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class BusquedaController extends Controller
{

    public function buscarAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repoPacientes = $em->getRepository('SalitaPacienteBundle:Paciente');
        $busqueda= new Busqueda();
        $form = $this->createForm(new BusquedaType(), $busqueda);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);      
            if ($form->isValid())
            {
                 switch ($busqueda->getCriterio())
                 {
                     case 'DNI':
                         $pacientes = $repoPacientes->buscarPorDNI($busqueda->getPalabra());
                         break;
                     case 'Apellido':
                         $pacientes = $repoPacientes->buscarPorApellido($busqueda->getPalabra());
                         break;
                     case 'Nombre':
                         $pacientes = $repoPacientes->buscarPorNombre($busqueda->getPalabra());
                         break;
                 }
                 return $this->render('SalitaPacienteBundle:Busqueda:resultado.html.twig', array('pacientes' => $pacientes,'rol' => $rolSeleccionado->getCodigo(), 'nombreRol' => $rolSeleccionado->getNombre(),
            ));
            }
        }
        else
        {
            return $this->render('SalitaPacienteBundle:Busqueda:ingresoDatos.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(), 'nombreRol' => $rolSeleccionado->getNombre(),
            ));
        }
    }
}
