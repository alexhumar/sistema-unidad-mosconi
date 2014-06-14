<?php
namespace Salita\PlanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MetodoAnticonceptivoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', 'textarea', array('required' => 'true', 'label' => 'Nombre'))
        		->add('guardar', 'submit');
    }

    public function getName()
    {
        return 'metodoanticonceptivo';
    }
}