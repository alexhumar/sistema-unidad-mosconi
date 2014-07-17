<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BusquedaDiagnosticoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('palabra', null, array('label' => 'Diagnostico'))
        		->add('buscar', 'submit', array('label' => 'Buscar diagnostico'));
    }

    public function getName()
    {
        return 'busquedaDiagnostico';
    }
}