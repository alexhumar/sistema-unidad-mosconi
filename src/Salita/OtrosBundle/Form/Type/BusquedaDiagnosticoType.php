<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BusquedaDiagnosticoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('palabra', null, array('label' => 'Diagnostico'))
        		->add('guardar', 'submit');
    }

    public function getName()
    {
        return 'busquedaDiagnostico';
    }

}