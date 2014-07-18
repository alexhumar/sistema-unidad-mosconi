<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AntecedenteFamiliarClinicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('cardiovascularMenorA55', 'checkbox', array('label' => 'Cardiovascular menor a 55', 'required' => false))
            ->add('asma', 'checkbox', array('label' => 'Asma', 'required' => false))
            ->add('trastornosMentales', 'checkbox', array('label' => 'Trastornos mentales', 'required' => false))
            ->add('alergias', 'checkbox', array('label' => 'Alergias', 'required' => false))
            ->add('adiccionesTabaquismo', 'checkbox', array('label' => 'Adicciones/Tabaquismo', 'required' => false))
            ->add('infectoContagiosas', 'checkbox', array('label' => 'Infectocontagiosas', 'required' => false))
            ->add('tuberculosis', 'checkbox', array('label' => 'Tuberculosis', 'required' => false))
            ->add('diabetes', 'checkbox', array('label' => 'Diabetes', 'required' => false))
            ->add('hipertensionArterial', 'checkbox', array('label' => 'Hipertensión arterial', 'required' => false))
            ->add('otros', 'textarea', array('label' => 'Otros', 'required' => false))
            ->add('modificar', submit, array('label' => 'Modificar antecedentes familiares clinicos'));
    }
    
    public function getName()
    {
        return 'antecedenteFamiliarClinico';
    }
}