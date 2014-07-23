<?php
namespace Salita\UsuarioBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Salita\UsuarioBundle\Entity\Rol;

class UsuarioRepository extends EntityRepository
{
    public function encontrarUsuariosOrdenadosPorNombre()
    {
        /* Recupera los usuarios ordenados por nombre */
    	return $this
    	         ->createQueryBuilder('u')
    	         ->orderBy('u.nombre', 'ASC')
    	         ->getQuery()
    	         ->getResult();
    }
    
    private function encontrarUsuariosRolOrdenadosPorNombre($codigoRol)
    {
    	/* Recupera los usuarios ordenados por nombre cuyo rol se corresponde con el codigo recibido 
    	   como parametro*/
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
        /* Recupera los medicos ordenados por nombre */
    	return $this->encontrarUsuariosRolOrdenadosPorNombre(Rol::getCodigoRolMedico());
    }

    public function encontrarSecretariasOrdenadasPorNombre()
    {
        /* Recupera las secretarias ordenadas por nombre */
    	return $this->encontrarUsuariosRolOrdenadosPorNombre(Rol::getCodigoRolSecretaria());
    }

    public function encontrarAdministradoresOrdenadosPorNombre()
    {
        /* Recupera los administradores ordenado por nombre*/
    	return $this->encontrarUsuariosRolOrdenadosPorNombre(Rol::getCodigoRolAdministrador());
    }
}