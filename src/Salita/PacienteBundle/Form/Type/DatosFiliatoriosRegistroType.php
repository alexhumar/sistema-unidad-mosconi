<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class DatosFiliatoriosRegistroType extends DatosFiliatoriosType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
    	
        $builder
            ->add('guardar', 'submit', array('label' => 'Registrar paciente'));
    }

    public function getName()
    {
        return 'registroDatosFiliatorios';
    }
}