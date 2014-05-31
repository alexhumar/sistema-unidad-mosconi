<?php

namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UsuarioType extends AbstractType
{
	private $rolSeleccionado;
	
	function __construct($rol)
	{
		parent::__construct();
		$this->setRolSeleccionado($rol);
	}
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre');
        $builder->add('apellido');
        $builder->add('email');
        $builder->add('telefono');
        /*Si el usuario es medico, muestra el campo para cargar la matricula.*/
        if ($this->getRolSeleccionado() == 'ROLE_MEDICO')
        {
        	$builder->add('matricula');
        }
    }

    public function getName()
    {
        return 'usuario';
    }
    
    private function getRolSeleccionado()
    {
    	return $this->rolSeleccionado;
    }
    
    private function setRolSeleccionad($rol)
    {
    	$this->rolSeleccionado = $rol;
    }

}


