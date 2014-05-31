<?php

namespace Salita\OtrosBundle\Clases;

class FechaYHoraTurno
{
    protected $dia;
    protected $mes; 
    protected $anio;
    protected $hora;
    protected $minutos;   
    protected $segundos;

    public function __construct()
    {
        $this->setSegundos('00');
    }

    public function getDia()
    {
        return $this->dia;
    }
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    public function getMes()
    {
        return $this->mes;
    }
    public function setMes($mes)
    {
        $this->mes = $mes;
    }

    public function getAnio()
    {
        return $this->anio;
    }
    public function setAnio($anio)
    {
        $this->anio = $anio;
    }

    public function getHora()
    {
        return $this->hora;
    }
    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    public function getMinutos()
    {
        return $this->minutos;
    }
    public function setMinutos($minutos)
    {
        $this->minutos = $minutos;
    }

    public function getSegundos()
    {
        return $this->segundos;
    }
    public function setSegundos($segundos)
    {
        $this->segundos = $segundos;
    } 

    public function getFecha()
    {
        return $this->dia.'-'.$this->mes.'-'.$this->anio;
    }

    public function getHoraCompleta()
    {
        return $this->hora.':'.$this->minutos.':'.$this->segundos;
    }
}
