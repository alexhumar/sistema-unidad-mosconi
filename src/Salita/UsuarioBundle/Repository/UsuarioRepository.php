<?php
namespace Salita\UsuarioBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Salita\UsuarioBundle\Entity\Rol;

class UsuarioRepository extends EntityRepository
{
    public function encontrarUsuariosOrdenadosPorNombre()
    {
        $sql = 'SELECT p 
                FROM SalitaUsuarioBundle:Usuario p 
                ORDER BY p.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->getResult();
    }

    public function encontrarMedicosOrdenadosPorNombre()
    {
        $sql = 'SELECT m 
                FROM SalitaUsuarioBundle:Usuario m JOIN m.rol r 
                WHERE r.codigo = :codigo_rol ORDER BY m.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('codigo_rol', Rol::getCodigoRolMedico())
            ->getResult();
    }

    public function encontrarSecretariasOrdenadasPorNombre()
    {
        $sql = 'SELECT m 
                FROM SalitaUsuarioBundle:Usuario m JOIN m.rol r 
                WHERE r.codigo = :codigo_rol 
                ORDER BY m.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('codigo_rol', Rol::getCodigoRolSecretaria())
            ->getResult();
    }

    public function encontrarAdministradoresOrdenadosPorNombre()
    {
        $sql = 'SELECT m 
                FROM SalitaUsuarioBundle:Usuario m JOIN m.rol r 
                WHERE r.codigo = :codigo_rol ORDER BY m.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('codigo_rol', Rol::getCodigoRolAdministrador())
            ->getResult();
    }
}