<?php
namespace Salita\PacienteBundle\Form\Type;

//use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AntecedenteFamiliarObstetricoType extends AntecedenteFamiliarType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
    	
        $builder
            ->add('preeclampsiaEclampsia', 'checkbox', array('label' => 'Preeclampasia/Eclampsia', 'required' => false))
            
            /*->add('tuberculosis', 'checkbox', array('label' => 'Tuberculosis', 'required' => false))
            ->add('diabetes', 'checkbox', array('label' => 'Diabetes', 'required' => false))
            ->add('hipertensionArterial', 'checkbox', array('label' => 'Hipertensión arterial', 'required' => false))
            ->add('otros', 'textarea', array('label' => 'Otros', 'required' => false))*/
            
            ->add('modificar', 'submit', array('label' => 'Modificar antecedentes familiares obstetricos'));
    }
    
    public function getName()
    {
        return 'antecedenteFamiliarObstetrico';
    }
}