<?php

//IMPORTANTE: algunos atributos se mapearon como nullables para poder crear mediante consola al usuario admin

namespace Salita\UsuarioBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\UserManager;
use Salita\UsuarioBundle\Entity\Rol;

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
    	$this->addRole($rol->getCodigo());
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
    	return $this->hasRole(Rol::getCodigoRolMedico());
    }
    
    public function isAdministrador()
    {
    	return (($this->hasRole(Rol::getCodigoRolAdministrador())) or ($this->hasRole(Rol::getCodigoRolAdmin())));
    }
    
    public function isSecretaria()
    {
    	return $this->hasRole(Rol::getCodigoRolSecretaria());
    }
    
    /* En los siguientes tres metodos no pregunto si es medico porque cuando se asigna el rol medico se
     * pide automaticamente la especialidad, y cuando se le quita el rol medico la especialidad se remueve
     * automaticamente, asi que van de la mano estas dos cosas */
    public function isClinico()
    {
    	return $this->getEspecialidad()->getCodigo() == Especialidad::getCodigoEspecialidadClinico();
    }
    
    public function isPediatra()
    {
    	return $this->getEspecialidad()->getCodigo() == Especialidad::getCodigoEspecialidadPediatra();
    }
    
    public function isObstetra()
    {
    	echo(var_dump($this->getEspecialidad()));die;
    	return $this->getEspecialidad()->getCodigo() == Especialidad::getCodigoEspecialidadObstetra();
    }
    
    /* Como en los templates twig no funcionan los metodos isObstetra, isPediatra e isAdministrador (me parece
     * que tiene que ver con que no puede reemplazar los proxies de doctrine con los objetos a partir de una
     * consulta a la bd desde twig.
     * creo estas versiones alternas para 
     *  */
    //Hacer los metodos
    
    public function isAuthenticatedAdministrador($rolSeleccionado)
    {
    	return $rolSeleccionado == Rol::getCodigoRolAdministrador();
    }
    
    public function isAuthenticatedMedico($rolSeleccionado)
    {
    	return $rolSeleccionado == Rol::getCodigoRolMedico();
    }
    
    public function isAuthenticatedSecretaria($rolSeleccionado)
    {
    	return $rolSeleccionado == Rol::getCodigoRolSecretaria();
    }
}