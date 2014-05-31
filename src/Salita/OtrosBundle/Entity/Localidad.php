<?php

namespace Salita\OtrosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="localidad")
 */

class Localidad
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable=false)
     */
    protected $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Salita\PacienteBundle\Entity\Paciente", mappedBy="localidad")
     */
    protected $pacientes;

    /**
     * @ORM\OneToMany(targetEntity="Salita\OtrosBundle\Entity\Barrio", mappedBy="localidad")
     */
    protected $barrios;

    public function __construct()
    {
        $this->pacientes= new ArrayCollection();
        $this->barrios= new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="Partido", inversedBy="localidades")
     * @ORM\JoinColumn(name="idPartido", referencedColumnName="id")
     */
    protected $partido;


    /**
     * Get idLocalidad
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add pacientes
     *
     * @param Salita\PacienteBundle\Entity\Paciente $pacientes
     */
    public function addPaciente(\Salita\PacienteBundle\Entity\Paciente $pacientes)
    {
        $this->pacientes[] = $pacientes;
    }

    /**
     * Get pacientes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPacientes()
    {
        return $this->pacientes;
    }

    /**
     * Add barrios
     *
     * @param Salita\OtrosBundle\Entity\Barrio $barrios
     */
    public function addBarrio(\Salita\OtrosBundle\Entity\Barrio $barrios)
    {
        $this->barrios[] = $barrios;
    }

    /**
     * Get barrios
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getBarrios()
    {
        return $this->barrios;
    }

    /**
     * Set partido
     *
     * @param Salita\OtrosBundle\Entity\Partido $partido
     */
    public function setPartido(\Salita\OtrosBundle\Entity\Partido $partido)
    {
        $this->partido = $partido;
    }

    /**
     * Get partido
     *
     * @return Salita\OtrosBundle\Entity\Partido 
     */
    public function getPartido()
    {
        return $this->partido;
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}
