<?php

namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistroFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        //aca se agregan los campos que necesitamos
        $builder->add('nombre');
        $builder->add('apellido');
        $builder->add('telefono');
        $builder->add('matricula');
    }

    public function getName()
    {
        return 'salita_usuario_registro';
    }
}
