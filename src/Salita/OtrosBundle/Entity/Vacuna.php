<?php

namespace Salita\OtrosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Salita\OtrosBundle\Repository\VacunaRepository")
 * @ORM\Table(name="vacuna")
 */

class Vacuna
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
     * @ORM\OneToMany(targetEntity="Salita\OtrosBundle\Entity\AplicacionVacuna", mappedBy="vacuna")
     */
    protected $aplicaciones;


    public function __construct()
    {
        $this->aplicaciones = new ArrayCollection();
    }


    /**
     * Get idVacuna
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
     * Add aplicaiones
     *
     * @param \Salita\OtrosBundle\Entity\AplicacionVacuna $aplicacion
     */
    public function addAplicaciones(\Salita\OtrosBundle\Entity\AplicacionVacuna $aplicacion)
    {
        $this->aplicaciones[] = $aplicacion;
    }

    /**
     * Get pacientes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAplicaciones()
    {
        return $this->aplicaciones;
    }
    
    public function __toString()
    {
    	return $this->getNombre();
    }
}
