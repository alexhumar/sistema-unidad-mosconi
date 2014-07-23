<?php
namespace Salita\PacienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AntecedentePersonalObstetricoRepository extends EntityRepository
{
    public function buscarAntecedenteDePaciente($idPaciente)
    {
    	/* Recupera el antecedente personal obstetrico del paciente */
    	return $this
    	         ->createQueryBuilder('apo')
    	         ->join('apo.paciente', 'p')
    	         ->where('p.id = :id_paciente')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->getQuery()
    	         ->getSingleResult();
    }
}