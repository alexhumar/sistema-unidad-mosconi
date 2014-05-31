<?php

namespace Salita\UsuarioBundle\Clases;

class RolTemporal
{
    protected $nombre;

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}
