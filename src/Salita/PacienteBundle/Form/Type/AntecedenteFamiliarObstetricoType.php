<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AntecedenteFamiliarObstetricoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('preeclampsiaEclampsia', 'checkbox', array('label' => 'Preeclampasia/Eclampsia', 'required' => false));        
        $builder->add('tuberculosis', 'checkbox', array('label' => 'Tuberculosis', 'required' => false));
        $builder->add('diabetes', 'checkbox', array('label' => 'Diabetes', 'required' => false));
        $builder->add('hipertensionArterial', 'checkbox', array('label' => 'Hipertensión arterial', 'required' => false));
        $builder->add('otros', 'textarea', array('label' => 'Otros', 'required' => false));
    }
    
    public function getName()
    {
        return 'antecedenteFamiliarObstetrico';
    }
}
