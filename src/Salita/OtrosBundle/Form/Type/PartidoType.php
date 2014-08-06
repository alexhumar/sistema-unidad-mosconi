<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PartidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', null, array('label' => 'form.partidoType.label.nombre'))
        		->add('guardar', 'submit', array('label' => 'form.partidoType.boton.guardar'))
        		->add('guardarynuevo', 'submit', array('label' => 'form.partidoType.boton.guardarYNuevo'));
    }

    public function getName()
    {
        return 'partido';
    }
}