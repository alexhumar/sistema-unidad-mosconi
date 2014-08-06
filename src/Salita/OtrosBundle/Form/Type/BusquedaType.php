<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BusquedaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('palabra','text', array('label' => 'form.busquedaType.label.vacuna'))
        		->add('buscar','submit', array('label' => 'form.busquedaType.boton.buscar'));
    }

    public function getName()
    {
        return 'busquedaVacuna';
    }

}