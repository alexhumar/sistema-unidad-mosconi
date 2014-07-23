<?php
namespace Salita\PlanBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PlanProcRespRepository extends EntityRepository
{
    public function findAllById($id)
    {
        /*$sql='SELECT p.id as id, p.periodicidad as periodicidad, m.nombre as nombre 
              FROM SalitaPlanBundle:PlanProcResp p JOIN p.metodoAnticonceptivo m 
              WHERE p.paciente = :id_paciente AND p.finalizado = 0';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_paciente', $id)
            ->getResult();*/
    	return $this
    	         ->createQueryBuilder('ppr')
    	         ->select('ppr.id as id, ppr.periodicidad as periodicidad, 
    	         		   m.nombre as nombre')
    	         ->join('ppr.metodoAnticonceptivo', 'm')
    	         ->where('ppr.paciente = :id_paciente AND ppr.finalizado = 0')
    	         ->setParameter('id_paciente', $id)
    	         ->getQuery()
    	         ->getResult();
    }

    public function findAllByIdDes($id)
    {
        /*$sql='SELECT p.id as id, p.periodicidad as periodicidad, m.nombre as nombre 
              FROM SalitaPlanBundle:PlanProcResp p JOIN p.metodoAnticonceptivo m 
              WHERE p.paciente = :id_paciente AND p.finalizado = 1';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_paciente', $id)
            ->getResult();*/
    	return $this
    	         ->createQueryBuilder('ppr')
    	         ->select('ppr.id as id, ppr.periodicidad as periodicidad, 
    	         		   m.nombre as nombre')
    	         ->join('ppr.metodoAnticonceptivo', 'm')
    	         ->where('ppr.paciente = :id_paciente AND ppr.finalizado = 1')
    	         ->setParameter('id_paciente', $id)
    	         ->getQuery()
    	         ->getResult();
    }

    public function habilitar($id)
    {
        /*$sql='UPDATE SalitaPlanBundle:PlanProcResp p 
              SET p.finalizado = 0 
              WHERE p.id = :id_plan';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_plan', $id)
            ->getResult();*/
    	return $this
    	         ->createQueryBuilder('ppr')
    	         ->update()
    	         ->set('ppr.finalizado', '0')
    	         ->where('ppr.id = :id_plan')
    	         ->setParameter('id_plan', $id)
    	         ->getQuery()
    	         ->execute();
    }

    public function deshabilitar($id)
    {
        /*$sql='UPDATE SalitaPlanBundle:PlanProcResp p 
              SET p.finalizado = 1 
              WHERE p.id = :id_plan';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_plan', $id)
            ->getResult();*/
    	return $this
    	         ->createQueryBuilder('ppr')
    	         ->update()
    	         ->set('ppr.finalizado', '1')
    	         ->where('ppr.id = :id_plan')
    	         ->setParameter('id_plan', $id)
    	         ->getQuery()
    	         ->execute();
    }
}