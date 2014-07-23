<?php
namespace Salita\OtrosBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DiagnosticoRepository extends EntityRepository
{
    public function buscarDiagnostico($diagnostico)
    {
        $diagnosticoAux = "%".$diagnostico."%";
        return $this
                 ->createQueryBuilder('d')
                 ->where('d.nombre LIKE :diagnostico')
                 ->setParameter('diagnostico', $diagnosticoAux)
                 ->orderBy('d.nombre', 'ASC')
                 ->getQuery()
                 ->getResult();
    }
}