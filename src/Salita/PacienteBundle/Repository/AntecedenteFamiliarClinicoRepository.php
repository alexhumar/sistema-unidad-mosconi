<?php
namespace Salita\PacienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AntecedenteFamiliarClinicoRepository extends EntityRepository
{
    public function buscarAntecedenteDePaciente($idPaciente)
    {
        /* Recupera el antecedente familiar clinico del paciente */
    	return $this
    	         ->createQueryBuilder('afc')
    	         ->join('afc.paciente', 'p')
    	         ->where('p.id = :id_paciente')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->getQuery()
    	         ->getSingleResult();
    }
}