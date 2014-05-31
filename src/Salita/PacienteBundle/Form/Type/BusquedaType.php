<?php

namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BusquedaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('palabra','text');
        $builder->add('criterio','choice',array('choices' => array('DNI' => 'DNI', 'Nombre' => 'Nombre', 'Apellido' => 'Apellido'),'required'  => true,));
    }

    public function getName()
    {
        return 'busqueda';
    }

}
