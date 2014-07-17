<?php
namespace Salita\TurnoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TurnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('especialidad')
        		->add('medicoPreferido', null , array('label' => 'Medico Preferido'))
        		->add('motivo')
        		->add('guardar', 'submit', array('label' => 'Guardar turno'));
    }

    public function getName()
    {
        return 'turno';
    }
}