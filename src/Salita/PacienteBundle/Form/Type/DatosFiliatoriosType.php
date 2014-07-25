<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\DataEvent;
use Doctrine\ORM\EntityRepository;

class DatosFiliatoriosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	
        $builder
            ->add('tipoDocumento', null, array('label' => 'Tipo de documento'))
            ->add('nroDoc', null, array('label' => 'Numero de documento'))
            ->add('nombre')
            ->add('apellido')
            ->add('fechaNacimiento', 'date', array('label' => 'Fecha de Nacimiento', 'years' => range(date("Y"), date("Y")-90)))
            ->add('sexo', 'choice', array('choices' => array(0 => 'Masculino', 1 => 'Femenino'),'required'  => true,))
            ->add('telefonoFijo', null, array('label' => 'Telefono Fijo'))
            ->add('telefonoMovil', null, array('label' => 'Telefono Movil'))
            ->add('pais')
            ->add('partido') 
            ->add('localidad')
            ->add('barrio')
            ->add('calle')
            ->add('numero')
            ->add('calleEntre1', null, array('label' => 'Entre calle'))
            ->add('calleEntre2', null, array('label' => 'y calle'));
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    		'data_class' => 'Salita\PacienteBundle\Entity\Paciente'  			
    	);
    }

    public function getName()
    {
        return 'datosFiliatoriosBase';
    }
}