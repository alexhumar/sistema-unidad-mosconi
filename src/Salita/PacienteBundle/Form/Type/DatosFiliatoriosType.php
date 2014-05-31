<?php

namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DatosFiliatoriosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tipoDocumento', null, array('label' => 'Tipo de documento'));
        $builder->add('nroDoc', null, array('label' => 'Numero de documento'));
        $builder->add('nombre');
        $builder->add('apellido');
        $builder->add('fechaNacimiento', 'date', array('label' => 'Fecha de Nacimiento', 'years' => range(date("Y"), date("Y")-90)));
        $builder->add('sexo', 'choice', array('choices' => array(0 => 'Masculino', 1 => 'Femenino'),'required'  => true,));
        $builder->add('telefonoFijo', null, array('label' => 'Telefono Fijo'));
        $builder->add('telefonoMovil', null, array('label' => 'Telefono Movil'));
        $builder->add('pais');
        $builder->add('partido');
        $builder->add('localidad');
        $builder->add('barrio');
        $builder->add('calle');
        $builder->add('numero');
        $builder->add('calleEntre1', null, array('label' => 'Entre calle'));
        $builder->add('calleEntre2', null, array('label' => 'y calle'));
    }

    public function getName()
    {
        return 'modificacionDatosFiliatorios';
    }

}
