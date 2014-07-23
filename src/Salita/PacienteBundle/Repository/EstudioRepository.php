<?php
namespace Salita\PacienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EstudioRepository extends EntityRepository
{
    public function obtenerEstudiosDePaciente($idPaciente)
    {
        /*$sql ='SELECT e.fecha as fecha, e.hora as hora, e.resultado as resultado, e.nroProtocolo as nroProtocolo, u.nombre as nombreUsuario, u.apellido as apellidoUsuario, m.nombre as metodoEstudio 
                FROM SalitaPacienteBundle:Estudio e JOIN e.paciente p JOIN e.usuario u JOIN e.metodoEstudio m 
                WHERE p.id = :id_paciente 
                ORDER BY e.fecha';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_paciente', $idPaciente)
            ->getResult();*/
    	return $this
    	         ->createQueryBuilder('e')
    	         ->select('e.fecha as fecha, e.hora as hora, e.resultado as resultado, 
    	         		   e.nroProtocolo as nroProtocolo, u.nombre as nombreUsuario, 
    	         		   u.apellido as apellidoUsuario, m.nombre as metodoEstudio')
    	         ->join('e.paciente', 'p')
    	         ->join('e.usuario', 'u')
    	         ->join('e.metodoEstudio', 'm')
    	         ->where('p.id = :id_paciente')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->orderBy('e.fecha')
    	         ->getQuery()
    	         ->getResult();
    }
}