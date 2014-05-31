<?php

namespace Salita\OtrosBundle\Clases;

class BusquedaDiagnostico
{
    protected $palabra;

    public function getPalabra()
    {
        return $this->palabra;
    }
    public function setPalabra($palabra)
    {
        $this->palabra = $palabra;
    }
}
