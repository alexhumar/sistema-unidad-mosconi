<?php

namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConsultaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('otrasAnotaciones', null, array('label' => 'Otras Anotaciones', 'required' => false))
            ->add('agregar', 'submit');

    }
    
    public function getName()
    {
        return 'consulta';
    }
}
