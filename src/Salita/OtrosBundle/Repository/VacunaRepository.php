<?php
namespace Salita\OtrosBundle\Repository;

use Doctrine\ORM\EntityRepository;

class VacunaRepository extends EntityRepository
{
    public function buscarVacuna($vacuna)
    {
        $vacunaAux = "%".$vacuna."%";
        return $this
                 ->createQueryBuilder('v')
                 ->where('v.nombre LIKE :vacuna')
                 ->setParameter('vacuna', $vacunaAux)
                 ->orderBy('v.nombre', 'ASC')
                 ->getQuery()
                 ->getResult();
    }
}