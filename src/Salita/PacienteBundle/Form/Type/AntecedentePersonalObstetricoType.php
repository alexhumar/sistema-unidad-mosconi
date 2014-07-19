<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AntecedentePersonalObstetricoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('cirugiaPelviana', 'checkbox', array('label' => 'Cirugía pelviana', 'required' => false))
            ->add('infertilidad', 'checkbox', array('label' => 'Infertilidad', 'required' => false))
            ->add('vih', 'checkbox', array('label' => 'VIH', 'required' => false))
            ->add('cardiopatiaNefropatia', 'checkbox', array('label' => 'Cardiopatía/Nefropatía', 'required' => false))
            ->add('condicionMedicaGrave', 'checkbox', array('label' => 'Condición médica grave', 'required' => false))
            ->add('gestasPrevias', 'number', array('label' => 'Gestas previas', 'required' => false))
            ->add('abortos', 'number', array('label' => 'Abortos', 'required' => false))
            ->add('cesareas', 'number', array('label' => 'Cesáreas', 'required' => false))
            ->add('partos', 'number', array('label' => 'Partos', 'required' => false))
            ->add('sifilis', 'checkbox', array('label' => 'Sífilis', 'required' => false))
            
            ->add('tuberculosis', 'checkbox', array('label' => 'Tuberculosis', 'required' => false))
            ->add('diabetes', 'checkbox', array('label' => 'Diabetes', 'required' => false))
            ->add('hipertensionArterial', 'checkbox', array('label' => 'Hipertensión arterial', 'required' => false))
            ->add('drogas', 'checkbox', array('label' => 'Drogas', 'required' => false))
            ->add('tabaquismo', 'checkbox', array('label' => 'Tabaquismo', 'required' => false))
            ->add('alcoholismo', 'checkbox', array('label' => 'Alcoholismo', 'required' => false))
            ->add('otros', 'textarea', array('label' => 'Otros', 'required' => false))
            
            ->add('modificar', 'submit', array('label' => 'Modificar antecedentes personales obstetricos'));
    }
    
    public function getName()
    {
        return 'antecedentePersonalObstetrico';
    }
}