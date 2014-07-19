<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class AntecedentePersonalClinicoType extends AntecedentePersonalType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
    	
        $builder
            ->add('medicamentos', 'checkbox', array('label' => 'Medicamentos', 'required' => false))
            ->add('tatuajes', 'checkbox', array('label' => 'Tatuajes', 'required' => false))
            ->add('infectoContagiosas', 'checkbox', array('label' => 'Infectocontagiosas', 'required' => false))
            ->add('traumatismos', 'checkbox', array('label' => 'Traumatismos', 'required' => false))
            ->add('internacionesPrevias', 'checkbox', array('label' => 'Internaciones previas', 'required' => false))
            ->add('modificar', 'submit', array('label' => 'Modificar antecedentes personales clinicos'));
    }
    
    public function getName()
    {
        return 'antecedentePersonalClinico';
    }
}