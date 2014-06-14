<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MetodoEstudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', 'textarea', array('required' => true, 'label' => 'Nombre'))
        		->add('guardar', 'submit')
        		->add('guardarynuevo', 'submit');
    }

    public function getName()
    {
        return 'metodoestudio';
    }
}