<?php
namespace Salita\PacienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AntecedenteFamiliarObstetricoRepository extends EntityRepository
{
    public function buscarAntecedenteDePaciente($idPaciente)
    {
    	/* Recupera el antecedente familiar obstetrico del paciente */
    	return $this
    	         ->createQueryBuilder('afo')
    	         ->join('afo.paciente', 'p')
    	         ->where('p.id = :id_paciente')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->getQuery()
    	         ->getSingleResult();
    }
}