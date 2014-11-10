<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
/*use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;*/

class ObservacionesHCType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	
        $builder
            ->add('observacionesHistoriaClinica', null, array('label' => 'form.observacionesHCType.label.observaciones'))
            ->add('modificar', 'submit', array('label' => 'form.observacionesHCType.boton.modificar'));

    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    		'data_class' => 'SalitaPacienteBundle:Paciente'  			
    	);
    }

    public function getName()
    {
        return 'observacionesHC';
    }
}