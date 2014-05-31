<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AntecedentePersonalObstetricoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('cirugiaPelviana', 'checkbox', array('label' => 'Cirugía pelviana', 'required' => false));
        $builder->add('infertilidad', 'checkbox', array('label' => 'Infertilidad', 'required' => false));
        $builder->add('vih', 'checkbox', array('label' => 'VIH', 'required' => false));
        $builder->add('cardiopatiaNefropatia', 'checkbox', array('label' => 'Cardiopatía/Nefropatía', 'required' => false));
        $builder->add('condicionMedicaGrave', 'checkbox', array('label' => 'Condición médica grave', 'required' => false));
        $builder->add('gestasPrevias', 'number', array('label' => 'Gestas previas', 'required' => false));
        $builder->add('abortos', 'number', array('label' => 'Abortos', 'required' => false));
        $builder->add('cesareas', 'number', array('label' => 'Cesáreas', 'required' => false));
        $builder->add('partos', 'number', array('label' => 'Partos', 'required' => false));
        $builder->add('sifilis', 'checkbox', array('label' => 'Sífilis', 'required' => false));
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
        return 'antecedentePersonalObstetrico';
    }
}
