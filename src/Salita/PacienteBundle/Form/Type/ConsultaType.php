<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConsultaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('otrasAnotaciones', null, array('label' => 'form.consultaType.label.otrasAnotaciones', 'required' => false))
            ->add('agregar', 'submit', array('label' => 'form.consultaType.boton.agregar'));

    }
    
    public function getName()
    {
        return 'consulta';
    }
}