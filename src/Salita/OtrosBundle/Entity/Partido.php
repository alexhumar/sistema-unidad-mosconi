<?php

namespace Salita\OtrosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Salita\OtrosBundle\Repository\PartidoRepository")
 * @ORM\Table(name="partido")
 */

class Partido
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
     * @ORM\OneToMany(targetEntity="Salita\OtrosBundle\Entity\Localidad", mappedBy="partido")
     */
    protected $localidades;

    public function __construct()
    {
        $this->localidades= new ArrayCollection();
    }


    /**
     * Get idPartido
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
     * Add localidades
     *
     * @param Salita\OtrosBundle\Entity\Localidad $localidades
     */
    public function addLocalidad(\Salita\OtrosBundle\Entity\Localidad $localidades)
    {
        $this->localidades[] = $localidades;
    }

    /**
     * Get localidades
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLocalidades()
    {
        return $this->localidades;
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}
