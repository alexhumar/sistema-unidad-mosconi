<?php
namespace Salita\PacienteBundle\Form\Type;

//use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DatosFiliatoriosModificacionType extends DatosFiliatoriosType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
    	
        $builder
            ->add('guardar', 'submit', array('label' => 'Modificar datos filiatorios de paciente'));
    }

    public function getName()
    {
        return 'modificacionDatosFiliatorios';
    }
}