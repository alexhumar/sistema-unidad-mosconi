<?php

namespace Salita\PacienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AntecedenteFamiliarClinicoRepository extends EntityRepository
{
    public function buscarAntecedenteDePaciente($idPaciente)
    {
        $sql = 'SELECT a 
                FROM SalitaPacienteBundle:AntecedenteFamiliarClinico a JOIN a.paciente p 
                WHERE p.id = :paciente_id';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('paciente_id', $idPaciente)
            ->getSingleResult();
    }
}
