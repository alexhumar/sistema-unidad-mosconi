<?php
namespace Salita\PlanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class PlanProcRespType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('periodicidad', null, array('required' => 'false', 'label' => 'form.planProcRespType.label.periodicidad'))
        		->add('metodoAnticonceptivo', 'entity', 
        					array('class' => 'SalitaPlanBundle:MetodoAnticonceptivo',
    							  'query_builder' => function(EntityRepository $er) { 
    							                         return $er
    							                                ->createQueryBuilder('m')
    							                                ->orderBy('m.nombre', 'ASC'); 
    							                     },
    						      'property' => 'nombre', 
    						      'label' => 'form.planProcRespType.label.metodoAnticonceptivo'))
    			->add('guardar', 'submit', array('label' => 'form.planProcRespType.boton.guardar'))
                ->add('guardarynuevo', 'submit', array('label' => 'form.planProcRespType.boton.guardarYNuevo'));
    }

    public function getName()
    {
        return 'planprocresp';
    }
}