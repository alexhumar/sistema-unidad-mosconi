<?php
namespace Salita\TurnoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class ListadoTurnosController extends Controller
{

    public function listarAction(Request $request)
    {
        $session = $request->getSession();
        $repoTurnos = $this->get('repos_manager')->getTurnosRepo();
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $turnos = $repoTurnos->turnosDelDia();
        return $this->render(
        			'SalitaTurnoBundle:Listados:turnosDelDia.html.twig',
        			array('turnos' => $turnos, 'rol' => $rolSeleccionado->getCodigo())
        		);
    }

    public function listarEspecialidadAction(Request $request)
    {
        $session = $request->getSession();
        echo("Hola 1");
        $especialidad = $session->get('usuario')->getEspecialidad();
        echo("Hola 2");
        $repoTurnos = $this->get('repos_manager')->getTurnosRepo();
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        /*Ojo que podria fallar. No estoy seguro que sea un usuario vigilado por el entity manager, asi que
         * podria ser que se sepa traer de la base la especialidad.*/
        $turnos = $repoTurnos->turnosDelDiaDeEspecialidad($especialidad);
        return $this->render(
        			'SalitaTurnoBundle:Listados:turnosDelDiaEspecialidad.html.twig',
        			array('turnos' => $turnos, 'rol' => $rolSeleccionado->getCodigo())
        		);
    }
}