<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MetodoEstudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', 'textarea', array('required' => true, 'label' => 'form.metodoEstudioType.label.nombre'))
        		->add('guardar', 'submit', array('label' => 'form.metodoEstudioType.boton.guardar'))
        		->add('guardarynuevo', 'submit', array('label' => 'form.metodoEstudioType.boton.guardarYNuevo'));
    }

    public function getName()
    {
        return 'metodoestudio';
    }
}