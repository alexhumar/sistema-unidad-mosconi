<?php
namespace Salita\OtrosBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Salita\OtrosBundle\Entity\Partido;

class LocalidadRepository extends EntityRepository
{
	/* Retorna un query builder utilizado en DatosFiliatoriosType */
	public function localidadesDePartidoQueryBuilder($partido)
	{
		$qb = $this
		        ->createQueryBuilder('localidad')
		        ->select('localidad')
		        ->join('localidad.partido', 'partido')
		        ->orderBy('localidad.nombre');
		if ($partido instanceof Partido)
		{
			$qb = $qb
			        ->where('partido = :partido')
			        ->setParameter('partido', $partido);
		}
		elseif (is_numeric($partido))
		{
			$qb = $qb
			        ->where('partido.id = :id_partido')
			        ->setParameter('id_partido', $partido);
		}
		else
		{
			$qb = $qb
			        ->where('partido.id = 1');
		}
		return $qb;
	}
}