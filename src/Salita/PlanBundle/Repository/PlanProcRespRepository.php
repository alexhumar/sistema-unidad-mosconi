<?php
namespace Salita\PlanBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PlanProcRespRepository extends EntityRepository
{
    public function findAllById($id)
    {
        $sql='SELECT p.id as id, p.periodicidad as periodicidad, m.nombre as nombre 
              FROM SalitaPlanBundle:PlanProcResp p JOIN p.metodoAnticonceptivo m 
              WHERE p.paciente = :id_paciente AND p.finalizado = 0';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_paciente', $id)
            ->getResult();
    }

    public function findAllByIdDes($id)
    {
        $sql='SELECT p.id as id, p.periodicidad as periodicidad, m.nombre as nombre 
              FROM SalitaPlanBundle:PlanProcResp p JOIN p.metodoAnticonceptivo m 
              WHERE p.paciente = :id_paciente AND p.finalizado = 1';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_paciente', $id)
            ->getResult();
    }

    public function habilitar($id)
    {
        $sql='UPDATE SalitaPlanBundle:PlanProcResp p 
              SET p.finalizado = 0 
              WHERE p.id = :id_plan';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_plan', $id)
            ->getResult();
    }

    public function deshabilitar($id)
    {
        $sql='UPDATE SalitaPlanBundle:PlanProcResp p 
              SET p.finalizado = 1 
              WHERE p.id = :id_plan';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_plan', $id)
            ->getResult();
    }
}