<?php

namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              ->add('nombre')
              ->add('apellido')
              ->add('email')
              ->add('telefono')
              ->add('matricula');
    }

    public function getName()
    {
        return 'usuario';
    }
}


