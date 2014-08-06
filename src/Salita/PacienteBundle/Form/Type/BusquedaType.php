<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BusquedaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('palabra','text', array('label' => 'form.paciente.busquedaType.label.palabra'))
            ->add('criterio','choice',array('choices' => array(
            		                        'DNI' => 'form.paciente.busquedaType.choice.dni', 
            		                        'Nombre' => 'form.paciente.busquedaType.choice.nombre', 
            		                        'Apellido' => 'form.paciente.busquedaType.choice.apellido'),
            		                        'required'  => true,
                                            'label' => 'form.paciente.busquedaType.label.criterio'))
            ->add('buscar', 'submit', array('label' => 'form.paciente.busquedaType.boton.buscar'));
    }

    public function getName()
    {
        return 'busqueda';
    }
}