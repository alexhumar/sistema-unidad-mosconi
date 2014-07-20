<?php
namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ChangePasswordFormType as BaseType;

/* ATENCION: form type creado como servicio para extender el original de FosUserBundle. Ver services.yml de
 * UsuarioBundle y el config.yml general */

class CambioPasswordFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        /* Aca se agregan los campos que necesitamos al formulario de cambio de contraseña */
        $builder
            ->add('cambiarPassword', 'submit', array('label' => 'Actualizar contraseña')); 
    }

    public function getName()
    {
        return 'salita_usuario_cambio_password';
    }
}