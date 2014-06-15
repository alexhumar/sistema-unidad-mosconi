<?php
namespace Salita\OtrosBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AplicacionVacunaRepository extends EntityRepository
{
    public function aplicacionesVacunaDePaciente($idPaciente)
    {
        $sql = 'SELECT v.nombre as nombreVacuna, a.fecha as fecha 
                FROM SalitaOtrosBundle:AplicacionVacuna a JOIN a.paciente p JOIN a.vacuna v 
                WHERE p.id = :id_paciente ORDER BY v.nombre';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_paciente', $idPaciente)
            ->getResult();
    }
}