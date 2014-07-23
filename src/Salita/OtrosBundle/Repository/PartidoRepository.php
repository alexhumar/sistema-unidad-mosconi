<?php
namespace Salita\OtrosBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PartidoRepository extends EntityRepository
{
    public function encontrarTodosOrdenadosPorNombre()
    {
    	return $this
    	         ->createQueryBuilder('p')
    	         ->orderBy('p.nombre', 'ASC')
    	         ->getQuery()
    	         ->getResult();
    }
}