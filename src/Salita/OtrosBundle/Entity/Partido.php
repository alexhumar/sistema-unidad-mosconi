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
    
    /**
     * @ORM\OneToMany(targetEntity="Salita\PacienteBundle\Entity\Paciente", mappedBy="partido")
     */
    protected $pacientes;

    public function __construct()
    {
        $this->localidades = new ArrayCollection();
        $this->pacientes = new ArrayCollection();
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
    
    /* Metodo especial para usar en DatosFiliatoriosType */
    public function getBarrios()
    {
    	echo("Hola 1");
    	$barrios = new ArrayCollection();
    	echo("Hola 2");
    	foreach($this->getLocalidades() as $localidad)
    	{
    		echo("Hola 3");
    		$iterator = $localidad->getBarrios()->getIterator();
    		echo("Hola 3");
    		while($iterator->valid())
    		{
    			echo("Hola 4");
    			$barrios->add($iterator->current());
    			echo("Hola 5");
    		}
    	}
    	
    	return $barrios;
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}
