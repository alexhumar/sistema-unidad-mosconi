<?php
namespace Salita\OtrosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BusquedaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('palabra','text', array('label' => 'Vacuna'))
        		->add('buscar','submit', array('label' => 'Buscar vacuna'));
    }

    public function getName()
    {
        return 'busquedaVacuna';
    }

}