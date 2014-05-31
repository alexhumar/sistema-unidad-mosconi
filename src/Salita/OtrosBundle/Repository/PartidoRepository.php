<?php

namespace Salita\OtrosBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PartidoRepository extends EntityRepository
{
    public function encontrarTodosOrdenadosPorNombre()
    {
        $sql = 'SELECT p 
                FROM SalitaOtrosBundle:Partido p 
                ORDER BY p.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->getResult();
    }
}
