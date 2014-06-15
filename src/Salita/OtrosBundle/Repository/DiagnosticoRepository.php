<?php
namespace Salita\OtrosBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DiagnosticoRepository extends EntityRepository
{
    public function buscarDiagnostico($diagnostico)
    {
        $diagnosticoAux = "%".$diagnostico."%";
        $sql = 'SELECT d 
                FROM SalitaOtrosBundle:Diagnostico d 
                WHERE d.nombre LIKE :diagnostico 
                ORDER BY d.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('diagnostico', $diagnosticoAux)
            ->getResult();
    }
}