<?php

namespace Salita\UsuarioBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="especialidad")
 */
class Especialidad
{	
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true, nullable=false)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=15, unique=true, nullable=false)
     */
    protected $codigo;

    /**
     * @ORM\OneToMany(targetEntity="Salita\TurnoBundle\Entity\Turno", mappedBy="especialidad")
     */
    protected $turnos;

    //agregue esto
    /**
     * @ORM\OneToMany(targetEntity="Salita\UsuarioBundle\Entity\Usuario", mappedBy="especialidad")
     */
    protected $usuarios;

    public function __construct()
    {
        $this->turnos= new ArrayCollection();
    }

    /**
     * Get idEspecialidad
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
     * Add turnos
     *
     * @param Salita\TurnoBundle\Entity\Turno $turnos
     */
    public function addTurno(\Salita\TurnoBundle\Entity\Turno $turnos)
    {
        $this->turnos[] = $turnos;
    }

    /**
     * Get turnos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTurnos()
    {
        return $this->turnos;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function __toString()
    {
        return $this->nombre;
    }
    
    public static function getCodigoNoTieneEspecialidad()
    {
    	return "NO_TIENE";
    }
}