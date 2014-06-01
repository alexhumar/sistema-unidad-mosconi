<?php

//IMPORTANTE: algunos atributos se mapearon como nullables para poder crear mediante consola al usuario admin

namespace Salita\UsuarioBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use FOS\UserBundle\Entity\UserManager;

/**
 * @ORM\Entity(repositoryClass="Salita\UsuarioBundle\Repository\UsuarioRepository")
 * @ORM\Table(name="usuario")
 * 
 */

class Usuario extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    protected $apellido;

    /**
     * @ORM\Column(type="string", length=15, nullable=false)
     */
    protected $telefono;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $matricula;

    /**
     * @ORM\ManyToMany(targetEntity="Salita\UsuarioBundle\Entity\Rol", inversedBy="usuarios")
     * @ORM\JoinTable(name="usuario_rol")
     */
    protected $rol;

    /**
     * @ORM\OneToMany(targetEntity="Salita\PacienteBundle\Entity\Visita", mappedBy="usuario")
     */
    protected $visitas;

    /**
     * @ORM\OneToMany(targetEntity="Salita\TurnoBundle\Entity\Turno", mappedBy="usuario")
     */
    protected $turnos;

    //agregue esto
    /**
     * @ORM\ManyToOne(targetEntity="Salita\UsuarioBundle\Entity\Especialidad", inversedBy="usuarios")
     * @ORM\JoinColumn(name="idEspecialidad", referencedColumnName="id")
     */
    protected $especialidad;

    public function __construct() {
        parent::__construct();
        $this->rol = new ArrayCollection();
        $this->visitas = new ArrayCollection();
        $this->turnos = new ArrayCollection();
    }

    /**
     * Get id
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
     * Set telefono
     *
     * @param string $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set matricula
     *
     * @param string $matricula
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
    }

    /**
     * Get matricula
     *
     * @return string 
     */
    public function getMatricula()
    {
        return $this->matricula;
    }
    /**
     * Get y set especialidad
     *
     * @return string 
     */
      public function getEspecialidad()
    {
        return $this->especialidad;
    }
    public function setEspecialidad($especialidad)
    {
        $this->especialidad = $especialidad;
    } 

    /**
     * Add rol
     *
     * @param Salita\UsuarioBundle\Entity\Rol $rol
     */
    public function addRol(\Salita\UsuarioBundle\Entity\Rol $rol)
    {
        $this->rol[] = $rol;
    }

    /**
     * Get roles usuario
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRolesUsuario()
    {
        return $this->rol;
    }


    /**
     * Add visitas
     *
     * @param Salita\PacienteBundle\Entity\Visita $visitas
     */
    public function addVisita(\Salita\PacienteBundle\Entity\Visita $visitas)
    {
        $this->visitas[] = $visitas;
    }

    /**
     * Get visitas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVisitas()
    {
        return $this->visitas;
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

    public function agregarRol($rol)
    {
        $this->addRole("'".$rol->getCodigo()."'");
        $this->addRol($rol);
    }

    public function quitarRol($rol)
    {
        $this->removeRole($rol->getCodigo());
        foreach ($this->rol as $nroRol => $rolAux){
            if ($rolAux == $rol->getNombre()){
                $idAux = $nroRol; 
            }
        }
        unset ($this->rol[$idAux]);
    }
    
    public function isMedico()
    {
    	return $this->hasRole("'ROLE_MEDICO'");
    }
    
    public function isAdministrador()
    {
    	return (($this->hasRole("'ROLE_ADMINISTRADOR'")) or ($this->hasRole("'ROLE_ADMIN'")));
    }
    
    public function isSecretaria()
    {
    	return $this->hasRole("'ROLE_SECRETARIA'");
    }
}
