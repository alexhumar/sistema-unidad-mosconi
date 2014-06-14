<?php
namespace Salita\PlanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PlanProcRespType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('periodicidad', 'number', array('required' => 'false', 'label' => 'Periodicidad'))
        		->add('metodoAnticonceptivo', 'entity', 
        					array('class' => 'SalitaPlanBundle:MetodoAnticonceptivo',
    							  'query_builder' => function($repository) 
    							  	{ return $repository->createQueryBuilder('m')->orderBy('m.id', 'ASC'); },
    								  'property' => 'nombre', 'label' => "Metodo Anticonceptivo"))
    			->add('guardar', 'submit');
    }

    public function getName()
    {
        return 'planprocresp';
    }
}