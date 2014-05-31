<?php

namespace Salita\PlanBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EntregaPlanProcRespRepository extends EntityRepository
{
    public function encontrarTodosOrdenadosPorFecha($id)
    {
        $sql = 'SELECT e.fecha as fecha, m.nombre as metodo, pac.nombre as nombrePac, pac.apellido as apellidoPac 
                FROM SalitaPlanBundle:EntregaPlanProcResp e JOIN e.plan p JOIN p.paciente pac JOIN p.metodoAnticonceptivo m 
                WHERE p.id = :id_plan 
                ORDER BY e.fecha DESC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_plan', $id)
            ->getResult();
    }
}
