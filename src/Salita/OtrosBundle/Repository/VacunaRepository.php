<?php

namespace Salita\OtrosBundle\Repository;

use Doctrine\ORM\EntityRepository;

class VacunaRepository extends EntityRepository
{
    public function buscarVacuna($vacuna)
    {
        $vacunaAux = "%".$vacuna."%";
        $sql = 'SELECT v 
                FROM SalitaOtrosBundle:Vacuna v 
                WHERE v.nombre LIKE :vacuna 
                ORDER BY v.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('vacuna', $vacunaAux)
            ->getResult();
    }
}
