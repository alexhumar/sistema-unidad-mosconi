<?php
namespace Salita\PlanBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EntregaPlanProcRespRepository extends EntityRepository
{
    public function findAllOrderedByFecha($id)
    {
        /* Recupera las entregas de un plan */
    	return $this
    	         ->createQueryBuilder('eppr')
    	         ->select('eppr.fecha as fecha, m.nombre as metodo, pac.nombre as nombrePac, 
    	         		   pac.apellido as apellidoPac')
    	         ->join('eppr.plan', 'p')
    	         ->join('p.paciente', 'pac')
    	         ->join('p.metodoAnticonceptivo', 'm')
    	         ->where('p.id = :id_plan')
    	         ->setParameter('id_plan', $id)
    	         ->orderBy('eppr.fecha', 'DESC')
    	         ->getQuery()
    	         ->getResult();
    }
}