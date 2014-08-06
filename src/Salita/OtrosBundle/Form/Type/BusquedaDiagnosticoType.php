<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BusquedaDiagnosticoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('palabra', null, array('label' => 'form.busquedaDiagnosticoType.label.diagnostico'))
        		->add('buscar', 'submit', array('label' => 'form.busquedaDiagnosticoType.boton.buscar'));
    }

    public function getName()
    {
        return 'busquedaDiagnostico';
    }
}