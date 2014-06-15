<?php
namespace Salita\PacienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AntecedentePersonalClinicoRepository extends EntityRepository
{
    public function buscarAntecedenteDePaciente($idPaciente)
    {
        $sql = 'SELECT a 
                FROM SalitaPacienteBundle:AntecedentePersonalClinico a JOIN a.paciente p 
                WHERE p.id = :id_paciente';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_paciente', $idPaciente)
            ->getSingleResult();
    }
}