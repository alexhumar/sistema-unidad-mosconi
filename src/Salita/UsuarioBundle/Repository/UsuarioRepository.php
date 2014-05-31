<?php

namespace Salita\UsuarioBundle\Repository;

use Doctrine\ORM\EntityRepository;

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
        $codigoRol = 'ROLE_MEDICO';
        $sql = 'SELECT m 
                FROM SalitaUsuarioBundle:Usuario m JOIN m.rol r 
                WHERE r.codigo = :codigo_rol ORDER BY m.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('codigo_rol', $codigoRol)
            ->getResult();
    }

    public function encontrarSecretariasOrdenadasPorNombre()
    {
        $codigoRol = 'ROLE_SECRETARIA';
        $sql = 'SELECT m 
                FROM SalitaUsuarioBundle:Usuario m JOIN m.rol r 
                WHERE r.codigo = :codigo_rol 
                ORDER BY m.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('codigo_rol', $codigoRol)
            ->getResult();
    }

    public function encontrarAdministradoresOrdenadosPorNombre()
    {
        $codigoRol = 'ROLE_ADMINISTRADOR';
        $sql = 'SELECT m 
                FROM SalitaUsuarioBundle:Usuario m JOIN m.rol r 
                WHERE r.codigo = :codigo_rol ORDER BY m.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('codigo_rol', $codigoRol)
            ->getResult();
    }
}
