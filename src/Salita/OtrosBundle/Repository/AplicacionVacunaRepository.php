<?php
namespace Salita\OtrosBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AplicacionVacunaRepository extends EntityRepository
{
    public function aplicacionesVacunaDePaciente($idPaciente)
    {

    	/* Utilizado en la historia clinica de paciente*/
    	return $this
    	         ->createQueryBuilder('av')
    	         ->select('v.nombre as nombreVacuna, av.fecha as fecha')
    	         ->join('av.paciente', 'p')
    	         ->join('av.vacuna', 'v')
    	         ->where('p.id = :id_paciente')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->orderBy('v.nombre')
    	         ->getQuery()
    	         ->getResult();
    }
    
    public function aplicacionesVacuna($idPaciente)
    {
    	
    	/* Utilizado para el listado de aplicaciones de vacuna para un paciente */
    	return $this
    	         ->createQueryBuilder('av')
    	         ->select('av.fecha as fecha, v.nombre as nombre')
    	         ->join('av.vacuna', 'v')
    	         ->where('av.paciente = :id_paciente')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->orderBy('av.fecha', 'ASC')
    	         ->getQuery()
    	         ->getResult();
    }
}