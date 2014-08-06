<?php
namespace Salita\TurnoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TurnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('especialidad', null, array('label' => 'form.turnoType.label.especialidad'))
        		->add('medicoPreferido', null , array('label' => 'form.turnoType.label.medicoPreferido'))
        		->add('motivo', null, array('label' => 'form.turnoType.label.motivo'))
        		->add('guardar', 'submit', array('label' => 'form.turnoType.boton.guardar'));
    }

    public function getName()
    {
        return 'turno';
    }
}