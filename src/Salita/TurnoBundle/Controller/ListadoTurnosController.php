<?php
namespace Salita\TurnoBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class ListadoTurnosController extends Controller
{

    public function listarAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $repoTurnos = $this->getDoctrine()->getEntityManager()->getRepository('SalitaTurnoBundle:Turno');
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $turnos = $repoTurnos->turnosDelDia();
        return $this->render('SalitaTurnoBundle:Listados:turnosDelDia.html.twig', array('turnos' => $turnos, 'rol' => $rolSeleccionado->getCodigo(),));
    }

    public function listarEspecialidadAction(Request $request)
    {
        //$session = $this->container->get('session');
        $session = $this->container->get('request')->getSession();
        $repoTurnos = $this->getDoctrine()->getEntityManager()->getRepository('SalitaTurnoBundle:Turno');
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $turnos = $repoTurnos->turnosDelDiaDeEspecialidad();
        return $this->render('SalitaTurnoBundle:Listados:turnosDelDiaEspecialidad.html.twig', array('turnos' => $turnos, 'rol' => $rolSeleccionado->getCodigo(),));
    }
}
