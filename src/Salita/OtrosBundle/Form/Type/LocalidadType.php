<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LocalidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')
        		->add('partido')
        		->add('guardar', 'submit')
        		->add('guardarynuevo', 'submit');
    }

    public function getName()
    {
        return 'localidad';
    }
}