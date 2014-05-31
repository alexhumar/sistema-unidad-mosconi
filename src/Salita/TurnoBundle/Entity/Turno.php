<?php

namespace Salita\TurnoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Salita\TurnoBundle\Repository\TurnoRepository")
 * @ORM\Table(name="turno")
 */

class Turno
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    protected $fecha;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    protected $hora;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $medicoPreferido;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $motivo;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $atendido;

    /**
     * @ORM\ManyToOne(targetEntity="Salita\UsuarioBundle\Entity\Usuario", inversedBy="turnos")
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="id")
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Salita\UsuarioBundle\Entity\Especialidad", inversedBy="turnos")
     * @ORM\JoinColumn(name="idEspecialidad", referencedColumnName="id")
     */
    protected $especialidad;

    /**
     * @ORM\ManyToOne(targetEntity="Salita\PacienteBundle\Entity\Paciente", inversedBy="turnos")
     * @ORM\JoinColumn(name="idPaciente", referencedColumnName="id")
     */
    protected $paciente;


    /**
     * Get idTurno
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param date $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Get fecha
     *
     * @return date 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param time $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    /**
     * Get hora
     *
     * @return time 
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set medicoPreferido
     *
     * @param string $medicoPreferido
     */
    public function setMedicoPreferido($medicoPreferido)
    {
        $this->medicoPreferido = $medicoPreferido;
    }

    /**
     * Get medicoPreferido
     *
     * @return string 
     */
    public function getMedicoPreferido()
    {
        return $this->medicoPreferido;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
    }

    /**
     * Get motivo
     *
     * @return string 
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set usuario
     *
     * @param Salita\UsuarioBundle\Entity\Usuario $usuario
     */
    public function setUsuario(\Salita\UsuarioBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return Salita\UsuarioBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set especialidad
     *
     * @param Salita\UsuarioBundle\Entity\Especialidad $especialidad
     */
    public function setEspecialidad(\Salita\UsuarioBundle\Entity\Especialidad $especialidad)
    {
        $this->especialidad = $especialidad;
    }

    /**
     * Get especialidad
     *
     * @return Salita\UsuarioBundle\Entity\Especialidad 
     */
    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    /**
     * Set paciente
     *
     * @param Salita\PacienteBundle\Entity\Paciente $paciente
     */
    public function setPaciente(\Salita\PacienteBundle\Entity\Paciente $paciente)
    {
        $this->paciente = $paciente;
    }

    /**
     * Get paciente
     *
     * @return Salita\PacienteBundle\Entity\Paciente 
     */
    public function getPaciente()
    {
        return $this->paciente;
    }

    /**
     * Set atendido
     *
     * @param boolean $atendido
     */
    public function setAtendido($atendido)
    {
        $this->atendido = $atendido;
    }

    /**
     * Get atendido
     *
     * @return boolean 
     */
    public function getAtendido()
    {
        return $this->atendido;
    }
}
