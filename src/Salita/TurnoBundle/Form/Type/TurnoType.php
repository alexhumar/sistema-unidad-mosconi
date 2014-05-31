<?php

namespace Salita\TurnoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TurnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('especialidad');
        $builder->add('medicoPreferido', null , array('label' => 'Medico Preferido'));
        $builder->add('motivo');
    }

    public function getName()
    {
        return 'turno';
    }

}
