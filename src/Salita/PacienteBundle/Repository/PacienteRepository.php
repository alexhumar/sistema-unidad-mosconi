<?php
namespace Salita\PacienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PacienteRepository extends EntityRepository
{
    public function buscarPorNombre($nombre)
    {
        $nombreAux = "%".$nombre."%";
        return $this
                 ->createQueryBuilder('p')
                 ->where('p.nombre LIKE :nombre')
                 ->setParameter('nombre', $nombreAux)
                 ->orderBy('p.nombre', 'ASC')
                 ->getQuery()
                 ->getResult();
    }

    public function buscarPorApellido($apellido)
    {
        $apellidoAux = "%".$apellido."%";
        return $this
                 ->createQueryBuilder('p')
                 ->where('p.apellido LIKE :apellido')
                 ->setParameter('apellido', $apellidoAux)
                 ->orderBy('p.apellido', 'ASC')
                 ->getQuery()
                 ->getResult();             
    }

    public function buscarPorDNI($dni)
    {
        $dniAux = "%".$dni."%";
        return $this
                 ->createQueryBuilder('p')
                 ->where('p.nroDoc LIKE :dni')
                 ->setParameter('dni', $dniAux)
                 ->orderBy('p.apellido', 'ASC')
                 ->getQuery()
                 ->getResult();
    }

    public function buscarDatosFiliatorios($idPaciente)
    {
    	return $this
    	         ->createQueryBuilder('p')
    	         ->where('p.id = :id_paciente')
    	         ->setParameter('id_paciente', $idPaciente)
    	         ->getQuery()
    	         ->getResult();
    }
}