<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class AntecedentePersonalObstetricoType extends AntecedentePersonalType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);

        $builder
            ->add('cirugiaPelviana', 'checkbox', array('label' => 'form.antecedentesType.label.cirugPelv', 'required' => false))
            ->add('infertilidad', 'checkbox', array('label' => 'form.antecedentesType.label.infert', 'required' => false))
            ->add('vih', 'checkbox', array('label' => 'form.antecedentesType.label.vih', 'required' => false))
            ->add('cardiopatiaNefropatia', 'checkbox', array('label' => 'form.antecedentesType.label.cardNef', 'required' => false))
            ->add('condicionMedicaGrave', 'checkbox', array('label' => 'form.antecedentesType.label.condMedGrave', 'required' => false))
            ->add('gestasPrevias', 'number', array('label' => 'form.antecedentesType.label.gestPrev', 'required' => false))
            ->add('abortos', 'number', array('label' => 'form.antecedentesType.label.abortos', 'required' => false))
            ->add('cesareas', 'number', array('label' => 'form.antecedentesType.label.cesareas', 'required' => false))
            ->add('partos', 'number', array('label' => 'form.antecedentesType.label.partos', 'required' => false))
            ->add('sifilis', 'checkbox', array('label' => 'form.antecedentesType.label.sifilis', 'required' => false))
            ->add('modificar', 'submit', array('label' => 'form.antecedentePersonalObstetricoType.boton.modificar'));
    }
    
    public function getName()
    {
        return 'antecedentePersonalObstetrico';
    }
}