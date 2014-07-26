<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\DataEvent;
use Doctrine\ORM\EntityRepository;

use Salita\PacienteBundle\Entity\Paciente;

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
            /*->add('partido') */
            ->add('localidad', 'choice', array('choices' => array()))
            ->add('barrio', 'choice', array('choices' => array()))
            ->add('calle')
            ->add('numero')
            ->add('calleEntre1', null, array('label' => 'Entre calle'))
            ->add('calleEntre2', null, array('label' => 'y calle'));
    
	    $factory = $builder->getFormFactory();
	    
	    $builder->add('partido', 'entity', array(
	    		'class' => 'Salita\OtrosBundle\Entity\Partido',
	    		'property' => 'nombre',
	    		'label' => 'Partido',
	    		'query_builder' =>  function(EntityRepository $er) {
	    			return $er->createQueryBuilder('partido')
	    			->select('partido')
	    			->orderBy('partido.nombre');
	    		},
	    ));
    
	   /* $refreshLocalidad =
		    function ($form, $partido) use ($factory)
		    {
		    	$form->add($factory->createNamed('entity', 'localidad', null, array(
		    			'class' => 'Salita\OtrosBundle\EntityLocalidad',
		    			'property' => 'nombre',
		    			'label' => 'Localidad',
		    			'query_builder' =>
		    			function (EntityRepository $repository) use ($partido)
		    			{   /* Es el repositorio de la entidad Localidad 
		    				$qb = $repository->localidadesDePartidoQueryBuilder($partido);
		    				return $qb;
		    			}
		    	)));
		    };*/
    
	    /*$refreshBarrio =
		    function($form, $localidad) use ($factory)
		    {
		    	$form->add($factory->createNamed('entity', 'barrio', null, array(
		    			'class' => 'Salita\OtrosBundle\Entity\Barrio',
		    			'property' => 'nombre',
		    			'label' => 'Barrio',
		    			'query_builder' =>
		    			function (EntityRepository $repository) use ($localidad)
		    			{
		    				$qb = $repository->barriosDeLocalidadQueryBuilder($localidad);
		    				return $qb;
		    			}
		    	)));
		    };*/
    
	    /*$builder->addEventListener(FormEvents::PRE_SET_DATA, function (DataEvent $event) use ($refreshLocalidad/*, $refreshBarrio) {
	    	$form = $event->getForm();
	    	$data = $event->getData();
	    
	    	if ($data == null){
	    		$refreshLocalidad($form, null);
	    		//$refreshBarrio($form, null);
	    	}
	    	
	    	if ($data instanceof Paciente) {
	    		$refreshLocalidad($form, $data->getPartido());
	    		//$refreshBarrio($form, $data->getLocalidad());
	    	}
	    });
	    
	    	$builder->addEventListener(FormEvents::PRE_BIND, function (DataEvent $event) use ($refreshLocalidad/*, $refreshBarrio) {
	    		$form = $event->getForm();
	    		$data = $event->getData();
	    
	    		if (array_key_exists('partido', $data)) {
	    			$refreshLocalidad($form, $data['partido']);
	    		}
	    		//if (array_key_exists('localidad', $data)) {
	    		//	$refreshBarrio($form, $data['localidad']);
	    		//}
	    	});*/
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