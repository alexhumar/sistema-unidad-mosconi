<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Symfony\Component\Form\Event\DataEvent;
use Doctrine\ORM\EntityRepository;

use Salita\PacienteBundle\Entity\Paciente;
use Salita\OtrosBundle\Entity\Partido;

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
	    
	    $builder
	        ->add('partido', 'entity', array(
	    		  'class' => 'SalitaOtrosBundle:Partido',
	    		  'property' => 'nombre',
	    		  'label' => 'Partido',
	    		  'empty_value' => ''
	    ));
    
	    $refreshLocalidad =
		    function (FormInterface $form, Partido $partido = null)// use ($factory)
		    {
		    	$localidaes = null === $partido ? array() : $partido->getLocalidades();	    	
		    	$form->add('localidad', 'entity', array(
		    		       'class' => 'SalitaOtrosBundle:Localidad',
		    			   'empty_value' => '',
		    			   'choices' => $localidaes
		    	));
		    };
    
	    $builder
	        ->addEventListener(
	        		FormEvents::PRE_SET_DATA, 
	        		function (FormEvent $event) use ($refreshLocalidad/*, $refreshBarrio*/) {
	    	            $form = $event->getForm();
	    	            $data = $event->getData();
	    		        $refreshLocalidad($form, $data->getPartido());
	        });
	    
	    $builder->get('partido')->addEventListener(
	    		FormEvents::POST_SUBMIT, 
	    		function (FormEvent $event) use ($refreshLocalidad/*, $refreshBarrio*/) {
	    			$form = $event->getForm();
	    			
	    			/* Es importante capturarlo de esta manera ya que $event->getData() retorna la client data
	    			 * (o sea, el ID). Esto estaba en el cookbook. Lo anoto para que quede. */
	    		    $partido = $event->getForm()->getData();
	    		    
	    		    /* Como el listener se agrego al hijo, tenemos que pasarlo el form padre a las funciones
	    		     * callback (estaba en el cookbook), no me cierra del todo */
	    			$refreshLocalidad($form->getParent(), $partido);
	    	});
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