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
use Salita\OtrosBundle\Entity\Localidad;

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
            ->add('localidad')
            ->add('barrio')
            ->add('calle')
            ->add('numero')
            ->add('calleEntre1', null, array('label' => 'Entre calle'))
            ->add('calleEntre2', null, array('label' => 'y calle'));
	    
	    $builder
	        ->add('partido', 'entity', array(
	    		  'class' => 'SalitaOtrosBundle:Partido',
	    		  'property' => 'nombre',
	    		  'label' => 'Partido',
	    		  'empty_value' => false
	    ));
    
	    $formModifier =
		    function (FormInterface $form, Partido $partido = null)
		    {
		    	if(partido == null)
		    	{
		    		$idPartido = null;
		    	}
		    	else
		    	{
		    		$idPartido = $partido->getId();
		    	}
		    	
		    	$form->add('localidad', 'entity', array(
		    		       'class' => 'SalitaOtrosBundle:Localidad',
		    			   'empty_value' => 'Selecciona una localidad',
		    			   'query_builder' =>
		    			             function(EntityRepository $er) use ($idPartido)
		    			             {
		    			                 return $er->localidadesDePartidoQueryBuilder($idPartido);
		    			             }
		    	));
		    	
		    	echo(var_dump($idPartido));
		    	
		    	//$idPartido = null == $partido ? null : $partido->getId();
		    	
		    	$form->add('barrio', 'entity', array(
		    			'class' => 'SalitaOtrosBundle:Barrio',
		    			'empty_value' => 'Selecciona un barrio',
		    			'query_builder' => 
		    			          function(EntityRepository $er) use ($idPartido)
		    			          {
		    			              return $er->barriosDePartidoQueryBuilder($idPartido);
		    			          }
		    	));
		    };
		    
	/*	$refreshBarrio = 
		    function (FormInterface $form, Localidad $localidad = null)
		    {
		    	$barrios = null === $localidad ? array() : $localidad->getBarrios();
		    	$form->add('barrio', 'entity', array(
		    		       'class' => 'SalitaOtrosBundle:Barrio',
		    			   'empty_value' => 'Selecciona un barrio',
		    			   'choices' => $barrios
		    	));
		    }; */

	    $builder
	        ->addEventListener(
	        		FormEvents::PRE_SET_DATA,
	        		function (FormEvent $event) use ($formModifier/*$refreshLocalidad, $refreshBarrio*/) {
	    	            $form = $event->getForm();
	    	            $paciente = $event->getData();
	    		        //$refreshLocalidad($form, $paciente->getPartido());
	    		        //$refreshBarrio($form, $paciente->getLocalidad());
	    		        $formModifier($form, $paciente->getPartido());
	        });
	    
	    $builder->get('partido')->addEventListener(
	    		FormEvents::POST_SUBMIT,
	    		function (FormEvent $event) use ($formModifier/*$refreshLocalidad*/) {
	    			$form = $event->getForm();
	    
	    			/* Es importante capturarlo de esta manera ya que $event->getData() retorna la client data
	    			 * (o sea, el ID). Esto estaba en el cookbook. Lo anoto para que quede. */
	    			$partido = $form->getData();
	    				
	    			/* Como el listener se agrego al hijo, tenemos que pasarlo el form padre a las funciones
	    			 * callback (estaba en el cookbook), no me cierra del todo */
	    			//$refreshLocalidad($form->getParent(), $partido);
	    			$formModifier($form->getParent(), $partido);
	    		});
	    
	    //ATENCION: no me esta agregando esto como event listener... verificar.
	   /* $builder->get('localidad')->addEventListener(
	    		FormEvents::POST_SUBMIT,
	    		function (FormEvent $event) use ($refreshBarrio) {
	    			$form = $event->getForm();
	    			 
	    			/* Es importante capturarlo de esta manera ya que $event->getData() retorna la client data
	    			 * (o sea, el ID). Esto estaba en el cookbook. Lo anoto para que quede. 
	    			$localidad = $event->getForm()->getData();
	    			 
	    			/* Como el listener se agrego al hijo, tenemos que pasarlo el form padre a las funciones
	    			 * callback (estaba en el cookbook), no me cierra del todo 
	    			$refreshBarrio($form->getParent(), $localidad);
	    		});*/
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    		'data_class' => 'SalitaPacienteBundle:Paciente'  			
    	);
    }

    public function getName()
    {
        return 'datosFiliatoriosBase';
    }
}