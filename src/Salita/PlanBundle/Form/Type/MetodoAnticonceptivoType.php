<?php
namespace Salita\PlanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MetodoAnticonceptivoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', 'textarea', array('required' => 'true', 'label' => 'Nombre'))
        		->add('guardar', 'submit')
        		->add('guardarynuevo', 'submit', array('label' => 'Guardar y nuevo'));
    }

    public function getName()
    {
        return 'metodoanticonceptivo';
    }
}