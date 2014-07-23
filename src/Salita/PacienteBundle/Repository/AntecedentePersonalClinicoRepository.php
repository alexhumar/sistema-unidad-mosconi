<?php
namespace Salita\PacienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AntecedentePersonalClinicoRepository extends EntityRepository
{
    public function buscarAntecedenteDePaciente($idPaciente)
    {
    	/* Recupera el antecedente personal clinico del paciente */
    	return $this
    	         ->createQueryBuilder('apc')
    	         ->join('apc.paciente', 'p')
    	         ->where('p.id = :id_paciente')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->getQuery()
    	         ->getSingleResult();
    }
}