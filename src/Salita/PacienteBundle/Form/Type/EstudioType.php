<?php

namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EstudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('resultado', 'textarea', array('label' => 'form.estudioType.label.resultado', 'required' => true))
            ->add('nroProtocolo', 'textarea', array('label' => 'form.estudioType.label.nroProtocolo', 'required' => true))
            ->add('metodoEstudio', 'entity', array('class' => 'SalitaOtrosBundle:MetodoEstudio',
    												   'query_builder' => function($repository) { return $repository->createQueryBuilder('m')->orderBy('m.id', 'ASC'); },
    												   'property' => 'nombre', 
                                                       'label' => 'form.estudioType.label.metodoEstudio'))
            ->add('agregar', 'submit', array('label' => 'form.estudioType.boton.agregar'));
    }
    
    public function getName()
    {
        return 'estudio';
    }
}