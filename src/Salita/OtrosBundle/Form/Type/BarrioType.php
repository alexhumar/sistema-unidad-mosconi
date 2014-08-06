<?php

namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BarrioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', null, array('label' => 'form.barrioType.label.nombre'))
        		->add('localidad', null, array('label' => 'form.barrioType.label.localidad'))
        		->add('guardar', 'submit', array('label' => 'form.barrioType.boton.guardar'))
        		->add('guardarynuevo', 'submit', array('label' => 'form.barrioType.boton.guardarYNuevo'));
    }

    public function getName()
    {
        return 'barrio';
    }

}