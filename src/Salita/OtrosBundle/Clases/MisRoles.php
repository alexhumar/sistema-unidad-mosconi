<?php

namespace Salita\OtrosBundle\Clases;

class MisRoles //esta clase es de prueba
{
    public function roles($em)
    {
        $_SESSION['idUsuarioSeleccionado'] = 1; //dato de prueba, en el controlador de "elegir rol para entrar en el sistema" setear esta variable
        $repRol = $em->getRepository('SalitaUsuarioBundle:Usuario');
        $usuario = $repRol->find(1);
        $roles = $usuario->getRoles();
        echo var_dump($roles);die();
        foreach ($roles as $rol)
        {
           echo $rol;
        }
        die();
    }
}
