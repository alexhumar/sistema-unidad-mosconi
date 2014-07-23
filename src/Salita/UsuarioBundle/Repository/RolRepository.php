<?php
namespace Salita\UsuarioBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Salita\UsuarioBundle\Entity\Rol;

class RolRepository extends EntityRepository
{
    public function findOneByCodigo($codigo)
    {     
        /* Recupera el rol correspondiente al codigo */
    	return $this
    	         ->createQueryBuilder('r')
    	         ->where('r.codigo = :codigo')
    	         ->setParameter('codigo', $codigo)
    	         ->getQuery()
    	         ->getSingleResult();
    }

    public function rolesAdministradorYMedico()
    {
        /* Recupera los roles administrador y medico */
    	return $this
    	         ->createQueryBuilder('r')
    	         ->where('r.codigo = :codigo_admin OR r.codigo = :codigo_medico')
    	         ->setParameter('codigo_admin', Rol::getCodigoRolAdministrador())
    	         ->setParameter('codigo_medico', Rol::getCodigoRolMedico())
    	         ->getQuery()
    	         ->getResult();
    }
}