<?php
namespace Salita\UsuarioBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Salita\UsuarioBundle\Entity\Rol;

class RolRepository extends EntityRepository
{
    public function findOneByCodigo($codigo)
    {     
        $sql = 'SELECT r 
                FROM SalitaUsuarioBundle:Rol r 
                WHERE r.codigo = :codigo';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('codigo', $codigo)
            ->getSingleResult();
    }

    public function rolesAdministradorYMedico()
    {
        $sql = 'SELECT r 
                FROM SalitaUsuarioBundle:Rol r 
                WHERE r.codigo = :codigo_admin OR r.codigo = :codigo_medico';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('codigo_admin', Rol::getCodigoRolAdministrador())
            ->setParameter('codigo_medico', Rol::getCodigoRolMedico())
            ->getResult();
    }
}