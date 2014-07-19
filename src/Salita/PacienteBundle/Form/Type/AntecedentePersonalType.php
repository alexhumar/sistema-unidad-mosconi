<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AntecedentePersonalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tuberculosis', 'checkbox', array('label' => 'Tuberculosis', 'required' => false))
            ->add('diabetes', 'checkbox', array('label' => 'Diabetes', 'required' => false))
            ->add('hipertensionArterial', 'checkbox', array('label' => 'Hipertensión arterial', 'required' => false))
            ->add('drogas', 'checkbox', array('label' => 'Drogas', 'required' => false))
            ->add('tabaquismo', 'checkbox', array('label' => 'Tabaquismo', 'required' => false))
            ->add('alcoholismo', 'checkbox', array('label' => 'Alcoholismo', 'required' => false))
            ->add('otros', 'textarea', array('label' => 'Otros', 'required' => false));
    }
    
    public function getName()
    {
        return 'antecedentePersonal';
    }
}