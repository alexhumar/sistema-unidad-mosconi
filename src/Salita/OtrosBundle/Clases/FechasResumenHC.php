<?php

namespace Salita\OtrosBundle\Clases;

class FechasResumenHC
{
    protected $diaDesde;
    protected $mesDesde; 
    protected $anioDesde;
    protected $diaHasta;
    protected $mesHasta;   
    protected $anioHasta;

    public function getDiaDesde()
    {
        return $this->diaDesde;
    }
    public function setDiaDesde($diaDesde)
    {
        $this->diaDesde = $diaDesde;
    }

    public function getMesDesde()
    {
        return $this->mesDesde;
    }
    public function setMesDesde($mesDesde)
    {
        $this->mesDesde = $mesDesde;
    }

    public function getAnioDesde()
    {
        return $this->anioDesde;
    }
    public function setAnioDesde($anioDesde)
    {
        $this->anioDesde = $anioDesde;
    }

    public function getDiaHasta()
    {
        return $this->diaHasta;
    }
    public function setDiaHasta($diaHasta)
    {
        $this->diaHasta = $diaHasta;
    }

    public function getMesHasta()
    {
        return $this->mesHasta;
    }
    public function setMesHasta($mesHasta)
    {
        $this->mesHasta = $mesHasta;
    }

    public function getAnioHasta()
    {
        return $this->anioHasta;
    }
    public function setAnioHasta($anioHasta)
    {
        $this->anioHasta = $anioHasta;
    } 

    public function getFechaDesde()
    {
        return $this->diaDesde.'-'.$this->mesDesde.'-'.$this->anioDesde;
    }

    public function getFechaHasta()
    {
        return $this->diaHasta.'-'.$this->mesHasta.'-'.$this->anioHasta;
    }

}
