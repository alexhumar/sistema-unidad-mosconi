<?php
namespace Salita\UsuarioBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Salita\UsuarioBundle\Entity\Rol;

class UsuarioRepository extends EntityRepository
{
    public function encontrarUsuariosOrdenadosPorNombre()
    {
        /*$sql = 'SELECT p 
                FROM SalitaUsuarioBundle:Usuario p 
                ORDER BY p.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->getResult();*/
    	return $this
    	         ->createQueryBuilder('u')
    	         ->orderBy('u.nombre', 'ASC')
    	         ->getQuery()
    	         ->getResult();
    }
    
    private function encontrarUsuariosRolOrdenadosPorNombre($codigoRol)
    {
    	return $this
    	         ->createQueryBuilder('u')
    	         ->join('u.rol', 'r')
    	         ->where('r.codigo = :codigo_rol')
    	         ->setParameter('codigo_rol', $codigoRol)
    	         ->orderBy('u.nombre', 'ASC')
    	         ->getQuery()
    	         ->getResult();   	
    }

    public function encontrarMedicosOrdenadosPorNombre()
    {
        /*$sql = 'SELECT m 
                FROM SalitaUsuarioBundle:Usuario m JOIN m.rol r 
                WHERE r.codigo = :codigo_rol ORDER BY m.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('codigo_rol', Rol::getCodigoRolMedico())
            ->getResult();*/
    	return $this->encontrarUsuariosRolOrdenadosPorNombre(Rol::getCodigoRolMedico());
    }

    public function encontrarSecretariasOrdenadasPorNombre()
    {
        /*$sql = 'SELECT m 
                FROM SalitaUsuarioBundle:Usuario m JOIN m.rol r 
                WHERE r.codigo = :codigo_rol 
                ORDER BY m.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('codigo_rol', Rol::getCodigoRolSecretaria())
            ->getResult();*/
    	return $this->encontrarUsuariosRolOrdenadosPorNombre(Rol::getCodigoRolSecretaria());
    }

    public function encontrarAdministradoresOrdenadosPorNombre()
    {
        /*$sql = 'SELECT m 
                FROM SalitaUsuarioBundle:Usuario m JOIN m.rol r 
                WHERE r.codigo = :codigo_rol ORDER BY m.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('codigo_rol', Rol::getCodigoRolAdministrador())
            ->getResult();*/
    	return $this->encontrarUsuariosRolOrdenadosPorNombre(Rol::getCodigoRolAdministrador());
    }
}