<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class DatosFiliatoriosModificacionType extends DatosFiliatoriosType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
    	
        $builder
            ->add('guardar', 'submit', array('label' => 'form.datosFiliatoriosModificacionType.boton.guardar'));
    }

    public function getName()
    {
        return 'modificacionDatosFiliatorios';
    }
}