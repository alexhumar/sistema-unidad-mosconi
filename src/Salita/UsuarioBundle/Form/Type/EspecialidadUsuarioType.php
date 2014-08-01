<?php
namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EspecialidadUsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('especialidad', null, array('required' => true))
        		->add('asignar', 'submit', array('label' => 'Asignar especialidad'));
    }

    public function getName()
    {
        return 'especialidadusuario';
    }
}