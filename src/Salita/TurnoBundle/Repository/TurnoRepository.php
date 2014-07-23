<?php
namespace Salita\TurnoBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TurnoRepository extends EntityRepository
{
    public function turnosDelDia()
    {
        $fechaHoy = Date("d-m-Y");
        /*$sql = 'SELECT p.nombre as nombre,p.apellido as apellido,t.motivo as motivo, 
                         t.fecha as fecha,t.hora as hora, t.medicoPreferido as medico, t.id as id, 
                         e.nombre as especialidad 
                  FROM SalitaTurnoBundle:Turno t JOIN t.paciente p JOIN t.especialidad e 
                  WHERE t.fecha = :fecha_hoy AND t.atendido = false';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('fecha_hoy', $fechaHoy)
            ->getResult();*/
        return $this
                 ->createQueryBuilder('t')
                 ->select('p.nombre as nombre, p.apellido as apellido, t.motivo as motivo, 
                 		   t.fecha as fecha, t.hora as hora, t.medicoPreferido as medico, 
                 		   t.id as id, e.nombre as especialidad')
                 ->join('t.paciente', 'p')
                 ->join('t.especialidad', 'e')
                 ->where('t.fecha = :fecha_hoy AND t.atendido = false')
                 ->setParameter('fecha_hoy', $fechaHoy)
                 ->getQuery()
                 ->getResult();
    }

    public function turnosDelDiaDeEspecialidad($especialidad)
    {
        $fechaHoy = Date("d-m-Y");
        /*$sql = 'SELECT p.nombre as nombre,p.apellido as apellido,t.motivo as motivo,t.fecha as fecha,
        		       t.hora as hora, t.medicoPreferido as medico, t.id as id 
                FROM SalitaTurnoBundle:Turno t JOIN t.paciente p JOIN t.especialidad e 
                WHERE t.fecha = :fecha_hoy AND e.id = :id_especialidad AND t.atendido = false';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('fecha_hoy', $fechaHoy)
            ->setParameter('id_especialidad', $especialidad->getId())
            ->getResult();*/
        return $this
                 ->createQueryBuilder('t')
                 ->select('p.nombre as nombre, p.apellido as apellido, t.motivo as motivo, 
                 		   t.fecha as fecha, t.hora as hora, t.medicoPreferido as medico, 
                 		   t.id as id')
                 ->join('t.paciente', 'p')
                 ->join('t.especialidad', 'e')
                 ->where('t.fecha = :fecha_hoy AND e.id = :id_especialidad AND t.atendido = false')
                 ->setParameter('fecha_hoy', $fechaHoy)
                 ->setParameter('id_especialidad', $especialidad->getId())
                 ->getQuery()
                 ->getResult();
    }
}