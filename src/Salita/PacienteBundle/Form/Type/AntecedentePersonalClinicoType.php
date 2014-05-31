<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AntecedentePersonalClinicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('medicamentos', 'checkbox', array('label' => 'Medicamentos', 'required' => false));
        $builder->add('tatuajes', 'checkbox', array('label' => 'Tatuajes', 'required' => false));
        $builder->add('infectoContagiosas', 'checkbox', array('label' => 'Infectocontagiosas', 'required' => false));
        $builder->add('traumatismos', 'checkbox', array('label' => 'Traumatismos', 'required' => false));
        $builder->add('internacionesPrevias', 'checkbox', array('label' => 'Internaciones previas', 'required' => false));        
        $builder->add('tuberculosis', 'checkbox', array('label' => 'Tuberculosis', 'required' => false));
        $builder->add('diabetes', 'checkbox', array('label' => 'Diabetes', 'required' => false));
        $builder->add('hipertensionArterial', 'checkbox', array('label' => 'Hipertensión arterial', 'required' => false));
        $builder->add('drogas', 'checkbox', array('label' => 'Drogas', 'required' => false));
        $builder->add('tabaquismo', 'checkbox', array('label' => 'Tabaquismo', 'required' => false));
        $builder->add('alcoholismo', 'checkbox', array('label' => 'Alcoholismo', 'required' => false));
        $builder->add('otros', 'textarea', array('label' => 'Otros', 'required' => false));
    }
    
    public function getName()
    {
        return 'antecedentePersonalClinico';
    }
}
