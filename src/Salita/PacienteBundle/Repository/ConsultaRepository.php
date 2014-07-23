<?php
namespace Salita\PacienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ConsultaRepository extends EntityRepository
{
    public function obtenerConsultasDePaciente($idPaciente)
    {
        /* Recupera las consultas del paciente */
    	return $this
    	         ->createQueryBuilder('c')
    	         ->select('c.fecha as fecha, c.hora as hora, c.otrasAnotaciones as otrasAnotaciones,
    	         		  u.nombre as nombreUsuario, u.apellido as apellidoUsuario, d.nombre as diagnostico')
    	         ->join('c.paciente', 'p')
    	         ->join('c.usuario', 'u')
    	         ->join('c.diagnostico', 'd')
    	         ->where('p.id = :id_paciente')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->orderBy('c.fecha')
    	         ->getQuery()
    	         ->getResult();
    }
}