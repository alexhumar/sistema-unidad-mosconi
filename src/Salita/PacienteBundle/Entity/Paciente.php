<?php

namespace Salita\PacienteBundle\Entity;

use Salita\OtrosBundle\Entity\AplicacionVacuna;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Salita\PacienteBundle\Repository\PacienteRepository")
 * @ORM\Table(name="paciente")
 */

class Paciente
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=20, unique=true, nullable=false)
     */
    protected $nroDoc;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $apellido;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    protected $fechaNacimiento;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $telefonoMovil;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $telefonoFijo;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $sexo;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $calle;

    /**
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    protected $numero;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $calleEntre1;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $calleEntre2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $observacionesHistoriaClinica;

    /**
     * @ORM\ManyToOne(targetEntity="Salita\OtrosBundle\Entity\TipoDocumento", inversedBy="pacientes")
     * @ORM\JoinColumn(name="idTipoDocumento", referencedColumnName="id")
     */
    protected $tipoDocumento;

    /**
     * @ORM\ManyToOne(targetEntity="Salita\OtrosBundle\Entity\Pais", inversedBy="pacientes")
     * @ORM\JoinColumn(name="idPais", referencedColumnName="id")
     */
    protected $pais;

    /**
     * @ORM\ManyToOne(targetEntity="Salita\OtrosBundle\Entity\Barrio", inversedBy="pacientes")
     * @ORM\JoinColumn(name="idBarrio", referencedColumnName="id")
     */
    protected $barrio;

    /**
     * @ORM\ManyToOne(targetEntity="Salita\OtrosBundle\Entity\Localidad", inversedBy="pacientes")
     * @ORM\JoinColumn(name="idLocalidad", referencedColumnName="id")
     */
    protected $localidad;

    /**
     * @ORM\ManyToOne(targetEntity="Salita\OtrosBundle\Entity\Partido", inversedBy="pacientes")
     * @ORM\JoinColumn(name="idPartido", referencedColumnName="id")
     */
    protected $partido;

    /**
     * @ORM\OneToMany(targetEntity="Salita\PlanBundle\Entity\PlanProcResp", mappedBy="paciente")
     */
    protected $planesProcResp;

    /**
     * @ORM\OneToMany(targetEntity="Salita\TurnoBundle\Entity\Turno", mappedBy="paciente")
     */
    protected $turnos;

    /**
     * @ORM\OneToMany(targetEntity="Salita\OtrosBundle\Entity\AplicacionVacuna", mappedBy="paciente")
     */
    protected $vacunas;

    /**
     * @ORM\OneToMany(targetEntity="Salita\PacienteBundle\Entity\AntecedentePersonal", mappedBy="paciente")
     */
    protected $antecedentePersonal;

    /**
     * @ORM\OneToMany(targetEntity="Salita\PacienteBundle\Entity\AntecedenteFamiliar", mappedBy="paciente")
     */
    protected $antecedenteFamiliar;

    /**
     * @ORM\OneToMany(targetEntity="Salita\PacienteBundle\Entity\Visita", mappedBy="paciente")
     */
    protected $visitas;

    public function __construct()
    {
        $this->planesProcResp= new ArrayCollection();
        $this->turnos= new ArrayCollection();
        $this->vacunas= new ArrayCollection();
        $this->visitas= new ArrayCollection();
    }

    /**
     * Get idPaciente
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nroDoc
     *
     * @param string $nroDoc
     */
    public function setNroDoc($nroDoc)
    {
        $this->nroDoc = $nroDoc;
    }

    /**
     * Get nroDoc
     *
     * @return string 
     */
    public function getNroDoc()
    {
        return $this->nroDoc;
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
     * Set apellido
     *
     * @param string $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set fechaNacimiento
     *
     * @param date $fechaNacimiento
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    /**
     * Get fechaNacimiento
     *
     * @return date 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set telefonoMovil
     *
     * @param string $telefonoMovil
     */
    public function setTelefonoMovil($telefonoMovil)
    {
        $this->telefonoMovil = $telefonoMovil;
    }

    /**
     * Get telefonoMovil
     *
     * @return string 
     */
    public function getTelefonoMovil()
    {
        return $this->telefonoMovil;
    }

    /**
     * Set telefonoFijo
     *
     * @param string $telefonoFijo
     */
    public function setTelefonoFijo($telefonoFijo)
    {
        $this->telefonoFijo = $telefonoFijo;
    }

    /**
     * Get telefonoFijo
     *
     * @return string 
     */
    public function getTelefonoFijo()
    {
        return $this->telefonoFijo;
    }

    /**
     * Set sexo
     *
     * @param boolean $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * Get sexo
     *
     * @return boolean 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set calle
     *
     * @param string $calle
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numero
     *
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set calleEntre1
     *
     * @param string $calleEntre1
     */
    public function setCalleEntre1($calleEntre1)
    {
        $this->calleEntre1 = $calleEntre1;
    }

    /**
     * Get calleEntre1
     *
     * @return string 
     */
    public function getCalleEntre1()
    {
        return $this->calleEntre1;
    }

    /**
     * Set calleEntre2
     *
     * @param string $calleEntre2
     */
    public function setCalleEntre2($calleEntre2)
    {
        $this->calleEntre2 = $calleEntre2;
    }

    /**
     * Get calleEntre2
     *
     * @return string 
     */
    public function getCalleEntre2()
    {
        return $this->calleEntre2;
    }

    /**
     * Set observacionesHistoriaClinica
     *
     * @param text $observacionesHistoriaClinica
     */
    public function setObservacionesHistoriaClinica($observacionesHistoriaClinica)
    {
        $this->observacionesHistoriaClinica = $observacionesHistoriaClinica;
    }

    /**
     * Get observacionesHistoriaClinica
     *
     * @return text 
     */
    public function getObservacionesHistoriaClinica()
    {
        return $this->observacionesHistoriaClinica;
    }

    /**
     * Set tipoDocumento
     *
     * @param Salita\OtrosBundle\Entity\TipoDocumento $tipoDocumento
     */
    public function setTipoDocumento(\Salita\OtrosBundle\Entity\TipoDocumento $tipoDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;
    }

    /**
     * Get tipoDocumento
     *
     * @return Salita\OtrosBundle\Entity\TipoDocumento 
     */
    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }

    /**
     * Set pais
     *
     * @param Salita\OtrosBundle\Entity\Pais $pais
     */
    public function setPais(\Salita\OtrosBundle\Entity\Pais $pais)
    {
        $this->pais = $pais;
    }

    /**
     * Get pais
     *
     * @return Salita\OtrosBundle\Entity\Pais 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set barrio
     *
     * @param Salita\OtrosBundle\Entity\Barrio $barrio
     */
    public function setBarrio(\Salita\OtrosBundle\Entity\Barrio $barrio)
    {
        $this->barrio = $barrio;
    }

    /**
     * Get barrio
     *
     * @return Salita\OtrosBundle\Entity\Barrio 
     */
    public function getBarrio()
    {
        return $this->barrio;
    }

    /**
     * Set localidad
     *
     * @param Salita\OtrosBundle\Entity\Localidad $localidad
     */
    public function setLocalidad(\Salita\OtrosBundle\Entity\Localidad $localidad)
    {
        $this->localidad = $localidad;
    }

    /**
     * Get localidad
     *
     * @return Salita\OtrosBundle\Entity\Localidad 
     */
    public function getLocalidad()
    {
        return $this->localidad;
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

    /**
     * Add planesProcResp
     *
     * @param Salita\PlanBundle\Entity\PlanProcResp $planesProcResp
     */
    public function addPlanProcResp(\Salita\PlanBundle\Entity\PlanProcResp $planesProcResp)
    {
        $this->planesProcResp[] = $planesProcResp;
    }

    /**
     * Get planesProcResp
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPlanesProcResp()
    {
        return $this->planesProcResp;
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
     * Add vacunas
     *
     * @param Salita\OtrosBundle\Entity\AplicacionVacuna $vacunas
     */
    public function addVacuna(AplicacionVacuna $vacuna)
    {

        $this->vacunas[] = $vacuna;
    }

    /**
     * Get vacunas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVacunas()
    {
        return $this->vacunas;
    }

    /**
     * Set antecedentePersonal
     *
     * @param Salita\PacienteBundle\Entity\AntecedentePersonal $antecedentePersonal
     */
    public function setAntecedentePersonal(\Salita\PacienteBundle\Entity\AntecedentePersonal $antecedentePersonal)
    {
        $this->antecedentePersonal = $antecedentePersonal;
    }

    /**
     * Get antecedentePersonal
     *
     * @return Salita\PacienteBundle\Entity\AntecedentePersonal 
     */
    public function getAntecedentePersonal()
    {
        return $this->antecedentePersonal;
    }

    /**
     * Set antecedenteFamiliar
     *
     * @param Salita\PacienteBundle\Entity\AntecedenteFamiliar $antecedenteFamiliar
     */
    public function setAntecedenteFamiliar(\Salita\PacienteBundle\Entity\AntecedenteFamiliar $antecedenteFamiliar)
    {
        $this->antecedenteFamiliar = $antecedenteFamiliar;
    }

    /**
     * Get antecedenteFamiliar
     *
     * @return Salita\PacienteBundle\Entity\AntecedenteFamiliar 
     */
    public function getAntecedenteFamiliar()
    {
        return $this->antecedenteFamiliar;
    }

    /**
     * Set visitas
     *
     * @param array $visitas
     */
    public function setVisitas($visitas)
    {
        $this->visitas = $visitas;
    }

    /**
     * Get visitas
     *
     * @return array 
     */
    public function getVisitas()
    {
        return $this->visitas;
    }
    
    /*Metodos propios*/
    
    public function isMujer()
    {
    	return $this->getSexo() == '1';
    }
    
    public function isHombre()
    {
    	return !$this->isMujer();
    }
}
