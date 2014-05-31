<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AntecedentePersonalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

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
        return 'antecedentePersonal';
    }
}
