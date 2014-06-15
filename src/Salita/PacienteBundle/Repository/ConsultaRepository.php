<?php
namespace Salita\PacienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ConsultaRepository extends EntityRepository
{
    public function obtenerConsultasDePaciente($idPaciente)
    {
        $sql = 'SELECT c.fecha as fecha, c.hora as hora, c.otrasAnotaciones as otrasAnotaciones, u.nombre as nombreUsuario, u.apellido as apellidoUsuario, d.nombre as diagnostico 
                FROM SalitaPacienteBundle:Consulta c JOIN c.paciente p JOIN c.usuario u JOIN c.diagnostico d 
                WHERE p.id = :id_paciente ORDER BY c.fecha';
        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('id_paciente', $idPaciente)
            ->getResult();
    }
}