<?php

namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EstudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('resultado', 'textarea', array('label' => 'Resultado', 'required' => true))
            ->add('nroProtocolo', 'textarea', array('label' => 'Nro de Protocolo', 'required' => true))
            ->add('metodoEstudio', 'entity', array('class' => 'SalitaOtrosBundle:MetodoEstudio',
    												   'query_builder' => function($repository) { return $repository->createQueryBuilder('m')->orderBy('m.id', 'ASC'); },
    												   'property' => 'nombre', 
                                                       'label' => "Metodo de estudio"))
            ->add('agregar', 'submit', array('label' => 'Agregar estudio'));
    }
    
    public function getName()
    {
        return 'estudio';
    }
}