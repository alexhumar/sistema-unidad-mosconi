<?php
namespace Salita\OtrosBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Salita\OtrosBundle\Entity\Localidad;

class BarrioRepository extends EntityRepository
{
	/* Retorna un query builder utilizado en DatosFiliatoriosType */
	public function barriosDeLocalidadQueryBuilder($localidad)
	{
		$qb = $this
		        ->createQueryBuilder('barrio')
		        ->select('barrio')
		        ->join('barrio.localidad', 'localidad')
		        ->orderBy('barrio.nombre');
		if ($localidad instanceof Localidad)
		{
			$qb = $qb
			        ->where('localidad = :localidad')
			        ->setParameter('localidad', $localidad);
		}
		elseif (is_numeric($localidad))
		{
			$qb = $qb
			        ->where('localidad.id = :id_localidad')
			        ->setParameter('id_localidad', $localidad);
		}
		else
		{
			$qb = $qb
			        ->where('localidad.id = 1');
		}
		return $qb;
	}
    
	public function barriosDeLocalidad($idLocalidad)
	{
		return $this
		    	->createQueryBuilder('barrio')
				->select('barrio')
				->join('barrio.localidad', 'localidad')
				->where('localidad.id = :id_localidad')
				->setParameter('id_localidad', $idLocalidad)
				->orderBy('barrio.nombre')
				->getQuery()
				->getResult();
	}
}