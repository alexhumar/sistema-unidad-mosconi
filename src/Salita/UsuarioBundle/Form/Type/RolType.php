<?php
namespace Salita\UsuarioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RolType extends AbstractType
{
    protected $roles;

    public function __construct($roles) {
        $this->roles = $roles;
    }

    public function getRoles()
    {
        foreach ($this->roles as $rol)
        {
            $rolesAux[$rol->getCodigo()] = $rol->getNombre();  
        }
        
        return $rolesAux;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre','choice', array('choices' => $this->getRoles(),'required' => true))
        		->add('asignar', 'submit');
    }

    public function getName()
    {
        return 'rolTemporal';
    }
}