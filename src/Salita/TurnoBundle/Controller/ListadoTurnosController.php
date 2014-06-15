<?php
namespace Salita\TurnoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class ListadoTurnosController extends Controller
{

    public function listarAction(Request $request)
    {
    	echo("Hola");
        $session = $request->getSession();
        echo ("Hola 2");
        $repoTurnos = $this->get('repos_manager')->getTurnosRepo();
        echo ("Hola 3");
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        echo ("Hola 4");
        $turnos = $repoTurnos->turnosDelDia();
        echo ("Hola 5");
        return $this->render(
        			'SalitaTurnoBundle:Listados:turnosDelDia.html.twig',
        			array('turnos' => $turnos, 'rol' => $rolSeleccionado->getCodigo())
        		);
    }

    public function listarEspecialidadAction(Request $request)
    {
        $session = $request->getSession();
        $usuario = $session->get('usuario');
        $repoTurnos = $this->get('repos_manager')->getTurnosRepo();
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        /*Ojo que podria fallar. No estoy seguro que sea un usuario vigilado por el entity manager, asi que
         * podria ser que se sepa traer de la base la especialidad.*/
        $turnos = $repoTurnos->turnosDelDiaDeEspecialidad($usuario->getEspecialidad());
        return $this->render(
        			'SalitaTurnoBundle:Listados:turnosDelDiaEspecialidad.html.twig',
        			array('turnos' => $turnos, 'rol' => $rolSeleccionado->getCodigo())
        		);
    }
}