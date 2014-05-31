<?php
namespace Salita\OtrosBundle\Controller;
use Salita\OtrosBundle\Form\Type\BusquedaType;
use Salita\OtrosBundle\Clases\Busqueda;
use Salita\OtrosBundle\Form\Type\BusquedaDiagnosticoType;
use Salita\OtrosBundle\Clases\BusquedaDiagnostico;
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
        $repoVacunas = $em->getRepository('SalitaOtrosBundle:Vacuna');
        $busqueda= new Busqueda();
        $form = $this->createForm(new BusquedaType(), $busqueda);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);          
            if ($form->isValid())
            {               
                 $vacunas = $repoVacunas->buscarVacuna($busqueda->getPalabra());
                 return $this->render('SalitaOtrosBundle:Busqueda:resultado.html.twig', array('vacunas' => $vacunas,'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),
            ));
            }
        }
        else
        {
            return $this->render('SalitaOtrosBundle:Busqueda:ingresoDatos.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),
            ));
        }
    }

    public function buscarDiagnosticoAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repoDiagnosticos = $em->getRepository('SalitaOtrosBundle:Diagnostico');
        $busqueda= new BusquedaDiagnostico();
        $form = $this->createForm(new BusquedaDiagnosticoType(), $busqueda);
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);         
            if ($form->isValid())
            {
                 $diagnosticos = $repoDiagnosticos->buscarDiagnostico($busqueda->getPalabra());
                 return $this->render('SalitaOtrosBundle:BusquedaDiagnostico:resultado.html.twig', array('diagnosticos' => $diagnosticos,'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
            }
        }
        else
        {
            return $this->render('SalitaOtrosBundle:BusquedaDiagnostico:ingresoDatos.html.twig', array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo(),'nombreRol' => $rolSeleccionado->getNombre(),));
        }
    }
}
