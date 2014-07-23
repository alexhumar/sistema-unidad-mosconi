<?php
namespace Salita\OtrosBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AplicacionVacunaRepository extends EntityRepository
{
    public function aplicacionesVacunaDePaciente($idPaciente)
    {
        /*$sql = 'SELECT v.nombre as nombreVacuna, a.fecha as fecha 
                FROM SalitaOtrosBundle:AplicacionVacuna a JOIN a.paciente p JOIN a.vacuna v 
                WHERE p.id = :id_paciente ORDER BY v.nombre';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_paciente', $idPaciente)
            ->getResult();*/
    	
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
    	/*$sql = 'SELECT a.fecha as fecha, v.nombre as nombre
                FROM SalitaOtrosBundle:AplicacionVacuna a JOIN a.vacuna v
                WHERE a.paciente = :id_paciente
                ORDER BY a.fecha ASC';
    	return $this->getEntityManager()
    	->createQuery($sql)
    	->setParameter('id_paciente', $idPaciente)
    	->getResult();*/
    	
    	/* Utilizado para el listado de aplicaciones de vacuna para un paciente */
    	return $this
    	         ->createQueryBuilder('av')
    	         ->select('av.fecha as fecha, v.nombre as nombre')
    	         ->join('av.vacuna', 'v')
    	         ->where('av.paciente = :id_paciente')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->orderBy('av.fecha', 'ASC')
    	         ->getQuey()
    	         ->getResult();
    }
}