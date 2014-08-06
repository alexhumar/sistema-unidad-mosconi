<?php
namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

/* ATENCION: form type creado como servicio para extender el original de FosUserBundle. Ver services.yml de
 * UsuarioBundle y el config.yml general */

class RegistroFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        /* Aca se agregan los campos que necesitamos al formulario de registro/modificacion de usuario */
        $builder
            ->add('nombre', null, array('label' => 'form.registroFormType.label.nombre'))
            ->add('apellido', null, array('label' => 'form.registroFormType.label.apellido'))
            ->add('telefono', null, array('label' => 'form.registroFormType.label.telefono'))
            ->add('matricula', null, array('label' => 'form.registroFormType.label.matricula'))
            ->add('registrar', 'submit', array('label' => 'form.registroFormType.boton.registrar')); 
    }

    public function getName()
    {
        return 'salita_usuario_registro';
    }
}