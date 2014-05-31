<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AntecedenteFamiliarClinicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('cardiovascularMenorA55', 'checkbox', array('label' => 'Cardiovascular menor a 55', 'required' => false));
        $builder->add('asma', 'checkbox', array('label' => 'Asma', 'required' => false));
        $builder->add('trastornosMentales', 'checkbox', array('label' => 'Trastornos mentales', 'required' => false));
        $builder->add('alergias', 'checkbox', array('label' => 'Alergias', 'required' => false));
        $builder->add('adiccionesTabaquismo', 'checkbox', array('label' => 'Adicciones/Tabaquismo', 'required' => false));
        $builder->add('infectoContagiosas', 'checkbox', array('label' => 'Infectocontagiosas', 'required' => false));
        $builder->add('tuberculosis', 'checkbox', array('label' => 'Tuberculosis', 'required' => false));
        $builder->add('diabetes', 'checkbox', array('label' => 'Diabetes', 'required' => false));
        $builder->add('hipertensionArterial', 'checkbox', array('label' => 'Hipertensión arterial', 'required' => false));
        $builder->add('otros', 'textarea', array('label' => 'Otros', 'required' => false));
    }
    
    public function getName()
    {
        return 'antecedenteFamiliarClinico';
    }
}
