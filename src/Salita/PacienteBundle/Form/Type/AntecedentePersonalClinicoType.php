<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class AntecedentePersonalClinicoType extends AntecedentePersonalType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
    	
        $builder
            ->add('medicamentos', 'checkbox', array('label' => 'form.antecedentesType.label.meds', 'required' => false))
            ->add('tatuajes', 'checkbox', array('label' => 'form.antecedentesType.label.tatuajes', 'required' => false))
            ->add('infectoContagiosas', 'checkbox', array('label' => 'form.antecedentesType.label.infectocont', 'required' => false))
            ->add('traumatismos', 'checkbox', array('label' => 'form.antecedentesType.label.traumat', 'required' => false))
            ->add('internacionesPrevias', 'checkbox', array('label' => 'form.antecedentesType.label.intPrev', 'required' => false))
            ->add('modificar', 'submit', array('label' => 'form.antecedentePersonalClinicoType.boton.modificar'));
    }
    
    public function getName()
    {
        return 'antecedentePersonalClinico';
    }
}