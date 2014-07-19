<?php
namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              ->add('nombre', null, array('required' => true))
              ->add('apellido', null, array('required' => true))
              ->add('email', null, array('required' => true))
              ->add('telefono', null, array('required' => true))
              ->add('matricula')
              ->add('modificar', 'submit');
    }

    public function getName()
    {
        return 'usuario';
    }
}