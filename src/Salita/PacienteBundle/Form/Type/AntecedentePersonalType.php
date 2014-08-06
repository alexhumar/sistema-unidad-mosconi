<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AntecedentePersonalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tuberculosis', 'checkbox', array('label' => 'form.antecedentesType.label.tuberculosis', 'required' => false))
            ->add('diabetes', 'checkbox', array('label' => 'form.antecedentesType.label.diabetes', 'required' => false))
            ->add('hipertensionArterial', 'checkbox', array('label' => 'form.antecedentesType.label.hipArt', 'required' => false))
            ->add('drogas', 'checkbox', array('label' => 'form.antecedentesType.label.drogas', 'required' => false))
            ->add('tabaquismo', 'checkbox', array('label' => 'form.antecedentesType.label.tabaquismo', 'required' => false))
            ->add('alcoholismo', 'checkbox', array('label' => 'form.antecedentesType.label.alcohol', 'required' => false))
            ->add('otros', 'textarea', array('label' => 'form.antecedentesType.label.otros', 'required' => false));
    }
    
    public function getName()
    {
        return 'antecedentePersonal';
    }
}