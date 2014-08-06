<?php
namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EspecialidadUsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('especialidad', null, array('label' => 'form.especialidadUsuarioType.label.especialidad', 'required' => true))
        		->add('asignar', 'submit', array('label' => 'form.especialidadUsuarioType.boton.asignar'));
    }

    public function getName()
    {
        return 'especialidadusuario';
    }
}