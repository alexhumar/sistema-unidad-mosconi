<?php
namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              ->add('nombre', null, array('label' => 'form.usuarioType.label.nombre', 'required' => true))
              ->add('apellido', null, array('label' => 'form.usuarioType.label.apellido', 'required' => true))
              ->add('email', null, array('label' => 'form.usuarioType.label.email', 'required' => true))
              ->add('telefono', null, array('label' => 'form.usuarioType.label.telefono', 'required' => true))
              ->add('matricula', null, array('label' => 'form.usuarioType.label.matricula'))
              ->add('modificar', 'submit', array('label' => 'form.usuarioType.boton.modificar'));
    }

    public function getName()
    {
        return 'usuario';
    }
}