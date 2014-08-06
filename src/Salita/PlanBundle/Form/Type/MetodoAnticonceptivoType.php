<?php
namespace Salita\PlanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MetodoAnticonceptivoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', 'textarea', array('required' => 'true', 'label' => 'form.metodoAnticonceptivoType.label.nombre'))
        		->add('guardar', 'submit', array('label' => 'form.metodoAnticonceptivoType.boton.guardar'))
        		->add('guardarynuevo', 'submit', array('label' => 'form.metodoAnticonceptivoType.boton.guardarYNuevo'));
    }

    public function getName()
    {
        return 'metodoanticonceptivo';
    }
}