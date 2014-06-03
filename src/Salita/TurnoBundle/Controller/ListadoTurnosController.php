<?php
namespace Salita\TurnoBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class ListadoTurnosController extends Controller
{
	private function getEntityManager()
	{
		return $this->getDoctrine()->getEntityManager();
	}
	
	private function getTurnosRepo()
	{
		$em = $this->getEntityManager();
		$em->getRepository('SalitaTurnoBundle:Turno');
	}

    public function listarAction(Request $request)
    {
        $session = $request->getSession();
        $repoTurnos = $this->getTurnosRepo();
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
        $repoTurnos = $this->getTurnosRepo();
        $rolSeleccionado = ConsultaRol::rolSeleccionado($session);
        $turnos = $repoTurnos->turnosDelDiaDeEspecialidad();
        return $this->render(
        			'SalitaTurnoBundle:Listados:turnosDelDiaEspecialidad.html.twig',
        			array('turnos' => $turnos, 'rol' => $rolSeleccionado->getCodigo())
        		);
    }
}