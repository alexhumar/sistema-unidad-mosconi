<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PartidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')
        		->add('guardar', 'submit')
        		->add('guardarynuevo', 'submit');
    }

    public function getName()
    {
        return 'partido';
    }
}