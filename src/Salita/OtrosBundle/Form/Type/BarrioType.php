<?php

namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BarrioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')
        		->add('localidad')
        		->add('guardar', 'submit');
    }

    public function getName()
    {
        return 'barrio';
    }

}


