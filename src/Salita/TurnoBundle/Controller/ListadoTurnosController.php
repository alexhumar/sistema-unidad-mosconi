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
        $usuario = $this->get('persistence_manager')->getRepoUserFromSessionUser($session->get('usuario'), $this);
        $repoTurnos = $this->get('repos_manager')->getTurnosRepo();
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $turnos = $repoTurnos->turnosDelDiaDeEspecialidad($usuario->getEspecialidad());
        return $this->render(
        			'SalitaTurnoBundle:Listados:turnosDelDiaEspecialidad.html.twig',
        			array('turnos' => $turnos, 'rol' => $rolSeleccionado->getCodigo())
        		);
    }
}