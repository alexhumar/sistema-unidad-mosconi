<?php
namespace Salita\PlanBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PlanProcRespRepository extends EntityRepository
{
    public function findAllById($idPaciente)
    {
        /* Recupera los planes habilitados del paciente */
    	return $this
    	         ->createQueryBuilder('ppr')
    	         ->select('ppr.id as id, ppr.periodicidad as periodicidad, 
    	         		   m.nombre as nombre')
    	         ->join('ppr.metodoAnticonceptivo', 'm')
    	         ->where('ppr.paciente = :id_paciente AND ppr.finalizado = 0')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->getQuery()
    	         ->getResult();
    }

    public function findAllByIdDes($idPaciente)
    {
        /* Recupera los planes deshabilitados del paciente */
    	return $this
    	         ->createQueryBuilder('ppr')
    	         ->select('ppr.id as id, ppr.periodicidad as periodicidad, 
    	         		   m.nombre as nombre')
    	         ->join('ppr.metodoAnticonceptivo', 'm')
    	         ->where('ppr.paciente = :id_paciente AND ppr.finalizado = 1')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->getQuery()
    	         ->getResult();
    }

    public function habilitar($idPlan)
    {
        /* Habilita el plan */
    	return $this
    	         ->createQueryBuilder('ppr')
    	         ->update()
    	         ->set('ppr.finalizado', '0')
    	         ->where('ppr.id = :id_plan')
    	         ->setParameter('id_plan', $idPlan)
    	         ->getQuery()
    	         ->execute();
    }

    public function deshabilitar($idPlan)
    {
        /* Deshabilita el plan */
    	return $this
    	         ->createQueryBuilder('ppr')
    	         ->update()
    	         ->set('ppr.finalizado', '1')
    	         ->where('ppr.id = :id_plan')
    	         ->setParameter('id_plan', $idPlan)
    	         ->getQuery()
    	         ->execute();
    }
}