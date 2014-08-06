<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PaisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', null, array('label' => 'form.paisType.label.nombre'))
        		->add('guardar', 'submit', array('label' => 'form.paisType.boton.guardar'))
        		->add('guardarynuevo', 'submit', array('label' => 'form.paisType.boton.guardarYNuevo'));
    }

    public function getName()
    {
        return 'pais';
    }
}