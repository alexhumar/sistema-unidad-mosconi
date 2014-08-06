<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class AntecedenteFamiliarObstetricoType extends AntecedenteFamiliarType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
    	
        $builder
            ->add('preeclampsiaEclampsia', 'checkbox', array('label' => 'form.antecedentesType.label.preecEcl', 'required' => false))
            ->add('modificar', 'submit', array('label' => 'form.antecedenteFamiliarObstetricoType.boton.modificar'));
    }
    
    public function getName()
    {
        return 'antecedenteFamiliarObstetrico';
    }
}