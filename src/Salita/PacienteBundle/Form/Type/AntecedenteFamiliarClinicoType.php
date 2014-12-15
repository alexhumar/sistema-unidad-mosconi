<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class AntecedenteFamiliarClinicoType extends AntecedenteFamiliarType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
        
        $builder
            ->add('cardiovascularMenorA55', 'checkbox', array('label' => 'form.antecedentesType.label.cardMenorA55', 'required' => false))
            ->add('asma', 'checkbox', array('label' => 'form.antecedentesType.label.asma', 'required' => false))
            ->add('trastornosMentales', 'checkbox', array('label' => 'form.antecedentesType.label.trastMent', 'required' => false))
            ->add('alergias', 'checkbox', array('label' => 'form.antecedentesType.label.alergias', 'required' => false))
            ->add('adiccionesTabaquismo', 'checkbox', array('label' => 'form.antecedentesType.label.adicTabaq', 'required' => false))
            ->add('infectoContagiosas', 'checkbox', array('label' => 'form.antecedentesType.label.infectocont', 'required' => false))
            ->add('modificar', 'submit', array('label' => 'form.antecedenteFamiliarClinicoType.boton.modificar'));
    }
    
    public function getName()
    {
        return 'antecedenteFamiliarClinico';
    }
}