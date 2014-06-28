<?php
namespace Salita\OtrosBundle\Clases;

class ConsultaEspecialidad
{

    public static function especialidadSeleccionada($session)
    {
         return $session->get('especialidad');
    }
}