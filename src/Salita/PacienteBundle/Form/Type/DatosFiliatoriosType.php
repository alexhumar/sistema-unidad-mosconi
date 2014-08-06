<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Salita\OtrosBundle\Entity\Partido;

class DatosFiliatoriosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	
        $builder
            ->add('tipoDocumento', null, array('label' => 'form.datosFiliatoriosType.label.tipoDocumento'))
            ->add('nroDoc', null, array('label' => 'form.datosFiliatoriosType.label.nroDoc'))
            ->add('nombre', null, array('label' => 'form.datosFiliatoriosType.label.nombre'))
            ->add('apellido', null, array('label' => 'form.datosFiliatoriosType.label.apellido'))
            ->add('fechaNacimiento', 'date', array('label' => 'form.datosFiliatoriosType.label.fecNac', 'years' => range(date("Y"), date("Y")-90)))
            ->add('sexo', 'choice', array('label' => 'form.datosFiliatoriosType.label.sexo', 
            		                      'choices' => array(
            		                      		       0 => 'form.datosFiliatoriosType.choice.masculino', 
            		                      		       1 => 'form.datosFiliatoriosType.choice.femenino'),
            		                      'required'  => true,))
            ->add('telefonoFijo', null, array('label' => 'form.datosFiliatoriosType.label.telFijo'))
            ->add('telefonoMovil', null, array('label' => 'form.datosFiliatoriosType.label.telMovil'))
            ->add('pais', null, array('label' => 'form.datosFiliatoriosType.label.pais'))
            ->add('calle', null, array('label' => 'form.datosFiliatoriosType.label.calle'))
            ->add('numero', null, array('label' => 'form.datosFiliatoriosType.label.numero'))
            ->add('calleEntre1', null, array('label' => 'form.datosFiliatoriosType.label.calleEntre1'))
            ->add('calleEntre2', null, array('label' => 'form.datosFiliatoriosType.label.calleEntre2'));
	    
	    $builder
	        ->add('partido', 'entity', array(
	    		  'class' => 'SalitaOtrosBundle:Partido',
	    		  'property' => 'nombre',
	    		  'label' => 'form.datosFiliatoriosType.label.partido',
	    		  'empty_value' => false
	    ));
    
	    $formModifier =
		    function (FormInterface $form, Partido $partido = null)
		    {
		    	$localidades = null === $partido ? array() : $partido->getLocalidades();	    	
		    	$form->add('localidad', 'entity', array(
		    		       'class' => 'SalitaOtrosBundle:Localidad',
		    			   'empty_value' => 'form.datosFiliatoriosType.widget.localidad.emptyValue',
		    			   'label' => 'form.datosFiliatoriosType.label.localidad',
		    			   'choices' => $localidades
		    	));
		    	
		    	$barrios = null === $partido ? array() : $partido->getBarrios();
		    	$form->add('barrio', 'entity', array(
		    			'class' => 'SalitaOtrosBundle:Barrio',
		    			'empty_value' => 'form.datosFiliatoriosType.widget.barrio.emptyValue',
		    			'label' => 'form.datosFiliatoriosType.label.barrio',
		    			'choices' => $barrios
		    	));
		    };

	    $builder
	        ->addEventListener(
	        		FormEvents::PRE_SET_DATA,
	        		function (FormEvent $event) use ($formModifier) {
	    	            $paciente = $event->getData();
	    		        $formModifier($event->getForm(), $paciente->getPartido());
	        });
	    
	    $builder->get('partido')->addEventListener(
	    		FormEvents::POST_SUBMIT,
	    		function (FormEvent $event) use ($formModifier) {
	    
	    			/* Es importante capturarlo de esta manera ya que $event->getData() retorna la client data
	    			 * (o sea, el ID). Esto estaba en el cookbook. Lo anoto para que quede. */
	    			$partido = $event->getForm()->getData();
	    				
	    			/* Como el listener se agrego al hijo, tenemos que pasarlo el form padre a las funciones
	    			 * callback (estaba en el cookbook), no me cierra del todo */
	    			$formModifier($event->getForm()->getParent(), $partido);
	    		});
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