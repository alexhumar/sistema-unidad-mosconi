<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AntecedentePersonalClinicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('medicamentos', 'checkbox', array('label' => 'Medicamentos', 'required' => false))
            ->add('tatuajes', 'checkbox', array('label' => 'Tatuajes', 'required' => false))
            ->add('infectoContagiosas', 'checkbox', array('label' => 'Infectocontagiosas', 'required' => false))
            ->add('traumatismos', 'checkbox', array('label' => 'Traumatismos', 'required' => false))
            ->add('internacionesPrevias', 'checkbox', array('label' => 'Internaciones previas', 'required' => false))
            ->add('tuberculosis', 'checkbox', array('label' => 'Tuberculosis', 'required' => false))
            ->add('diabetes', 'checkbox', array('label' => 'Diabetes', 'required' => false))
            ->add('hipertensionArterial', 'checkbox', array('label' => 'Hipertensión arterial', 'required' => false))
            ->add('drogas', 'checkbox', array('label' => 'Drogas', 'required' => false))
            ->add('tabaquismo', 'checkbox', array('label' => 'Tabaquismo', 'required' => false))
            ->add('alcoholismo', 'checkbox', array('label' => 'Alcoholismo', 'required' => false))
            ->add('otros', 'textarea', array('label' => 'Otros', 'required' => false))
            ->add('modificar', 'submit', array('label' => 'Modificar antecedentes personales clinicos'));
    }
    
    public function getName()
    {
        return 'antecedentePersonalClinico';
    }
}