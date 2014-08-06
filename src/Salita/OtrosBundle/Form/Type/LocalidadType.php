<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LocalidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', null, array('label' => 'form.localidadType.label.nombre'))
        		->add('partido', null, array('label' => 'form.localidadType.label.partido'))
        		->add('guardar', 'submit', array('label' => 'form.localidadType.boton.guardar'))
        		->add('guardarynuevo', 'submit', array('label' => 'form.localidadType.boton.guardarYNuevo'));
    }

    public function getName()
    {
        return 'localidad';
    }
}