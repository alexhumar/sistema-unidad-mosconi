<?php
namespace Salita\PacienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PacienteRepository extends EntityRepository
{
    public function buscarPorNombre($nombre)
    {
        $nombreAux = "%".$nombre."%";
        /*$sql = 'SELECT p 
                FROM SalitaPacienteBundle:Paciente p 
                WHERE p.nombre LIKE :nombre ORDER BY p.nombre ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('nombre', $nombreAux)
            ->getResult();*/
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
        $sql = 'SELECT p 
                FROM SalitaPacienteBundle:Paciente p 
                WHERE p.apellido LIKE :apellido 
                ORDER BY p.apellido ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('apellido', $apellidoAux)
            ->getResult();
    }

    public function buscarPorDNI($dni)
    {
        $dniAux = "%".$dni."%";
        $sql = 'SELECT p 
                FROM SalitaPacienteBundle:Paciente p 
                WHERE p.nroDoc LIKE :dni 
                ORDER BY p.apellido ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('dni', $dniAux)
            ->getResult();
    }

    public function aplicacionesVacuna($idPaciente)
    {
        $sql = 'SELECT a.fecha as fecha, v.nombre as nombre 
                FROM SalitaOtrosBundle:AplicacionVacuna a JOIN a.vacuna v 
                WHERE a.paciente = :id_paciente 
                ORDER BY a.fecha ASC';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_paciente', $idPaciente)
            ->getResult();
    }

    public function buscarDatosFiliatorios($idPaciente)
    {
        $sql = 'SELECT p 
                FROM SalitaPacienteBundle:Paciente p 
                WHERE p.id = :id_paciente';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_paciente', $idPaciente)
            ->getResult();
    }
}