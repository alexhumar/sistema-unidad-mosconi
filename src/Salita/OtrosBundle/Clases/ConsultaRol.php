<?php

namespace Salita\OtrosBundle\Clases;

class ConsultaRol
{

    public static function rolSeleccionado($session)
    {
         return $session->get('rolSeleccionado');
    }
}
