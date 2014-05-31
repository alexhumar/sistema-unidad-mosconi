<?php

namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UsuarioType extends AbstractType
{
<<<<<<< HEAD
	private rolSeleccionado;

	function __construct($rol)
	{
		parent::__construct();
		$this->rolSeleccionado = $rol;
	}
=======
>>>>>>> 8062407cbe43a7471224366d1aa01e2e82e87049
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre');
        $builder->add('apellido');
        $builder->add('email');
        $builder->add('telefono');
        $builder->add('matricula');
    }

    public function getName()
    {
        return 'usuario';
    }
}


