<?php

namespace Salita\PacienteBundle\Entity;

use Salita\PacienteBundle\Entity\Visita;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Salita\PacienteBundle\Repository\EstudioRepository")
 */
class Estudio extends Visita
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $resultado;

    /**
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    protected $nroProtocolo;

    /**
     * @ORM\ManyToOne(targetEntity="Salita\OtrosBundle\Entity\MetodoEstudio", inversedBy="estudios")
     * @ORM\JoinColumn(name="idMetodoEstudio", referencedColumnName="id")
     */
    protected $metodoEstudio;

    /**
     * @var date $fecha
     */
    protected $fecha;

    /**
     * @var time $hora
     */
    protected $hora;

    /**
     * Get idEstudio
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set resultado
     *
     * @param text $resultado
     */
    public function setResultado($resultado)
    {
        $this->resultado = $resultado;
    }

    /**
     * Get resultado
     *
     * @return text 
     */
    public function getResultado()
    {
        return $this->resultado;
    }

    /**
     * Set nroProtocolo
     *
     * @param string $nroProtocolo
     */
    public function setNroProtocolo($nroProtocolo)
    {
        $this->nroProtocolo = $nroProtocolo;
    }

    /**
     * Get nroProtocolo
     *
     * @return string 
     */
    public function getNroProtocolo()
    {
        return $this->nroProtocolo;
    }

    /**
     * Get idVisita
     *
     * @return integer 
     */
    public function getIdVisita()
    {
        return $this->idVisita;
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
     * Set metodoEstudio
     *
     * @param Salita\OtrosBundle\Entity\MetodoEstudio $metodoEstudio
     */
    public function setMetodoEstudio(\Salita\OtrosBundle\Entity\MetodoEstudio $metodoEstudio)
    {
        $this->metodoEstudio = $metodoEstudio;
    }

    /**
     * Get metodoEstudio
     *
     * @return Salita\OtrosBundle\Entity\MetodoEstudio 
     */
    public function getMetodoEstudio()
    {
        return $this->metodoEstudio;
    }

}
