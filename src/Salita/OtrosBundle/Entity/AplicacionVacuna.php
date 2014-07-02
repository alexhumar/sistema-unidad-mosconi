<?php

namespace Salita\OtrosBundle\Entity;

use Salita\OtrosBundle\Entity\Vacuna;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Salita\OtrosBundle\Repository\AplicacionVacunaRepository")
 * @ORM\Table(name="aplicacionvacuna")
 */

class AplicacionVacuna
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
     * @ORM\ManyToOne(targetEntity="Salita\PacienteBundle\Entity\Paciente", inversedBy="vacunas")
     * @ORM\JoinColumn(name="idPaciente", referencedColumnName="id")
     */
    protected $paciente;

    /**
     * @ORM\ManyToOne(targetEntity="Salita\OtrosBundle\Entity\Vacuna", inversedBy="aplicaciones")
     * @ORM\JoinColumn(name="idVacuna", referencedColumnName="id")
     */
    protected $vacuna;


    /**
     * Get idEntregaPlanProcResp
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
     * Set paciente
     *
     * @param \Salita\PacienteBundle\Entity\Paciente $paciente
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
    public function getpaciente()
    {
        return $this->paciente;
    }

    /**
     * Set vacuna
     *
     * @param \Salita\OtrosBundle\Entity\Vacuna $vacuna
     */
    public function setVacuna(Vacuna $vacuna)
    {
        $this->vacuna = $vacuna;
    }

    /**
     * Get vacuna
     *
     * @return Salita\OtrosBundle\Entity\Vacuna
     */
    public function getVacuna()
    {
        return $this->vacuna;
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}
