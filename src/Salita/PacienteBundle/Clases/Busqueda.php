<?php

namespace Salita\PacienteBundle\Clases;

class Busqueda
{
    protected $palabra;
    protected $criterio;

    public function getPalabra()
    {
        return $this->palabra;
    }
    public function setPalabra($palabra)
    {
        $this->palabra = $palabra;
    }

    public function getCriterio()
    {
        return $this->criterio;
    }
    public function setCriterio($criterio)
    {
        $this->criterio = $criterio;
    }
}
