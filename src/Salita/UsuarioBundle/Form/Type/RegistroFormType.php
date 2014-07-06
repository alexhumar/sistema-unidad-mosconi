<?php
namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistroFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        /* Aca se agregan los campos que necesitamos al formulario de registro/modificacion de usuario */
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('telefono')
            ->add('matricula');
    }

    public function getName()
    {
        return 'salita_usuario_registro';
    }
}