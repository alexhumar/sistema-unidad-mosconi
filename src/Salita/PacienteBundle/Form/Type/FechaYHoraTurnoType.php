<?php
namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FechaYHoraTurnoType extends AbstractType
{

    private function anteponerCeroADigitos()
    {
        for ($i=1;$i<=9;$i++)
        {
            $digitos['0'.(string)$i]='0'.(string)$i;
        }
        return $digitos;
    }

    private function anteponerCeroADigitosHora()
    {
        for ($i=0;$i<=9;$i++)
        {
            $digitos['0'.(string)$i]='0'.(string)$i;
        }
        return $digitos;
    }

    private function getDias()
    {
        $dias = $this->anteponerCeroADigitos();

        for ($i=10; $i<32; $i++)
        {
            $dias[(string)$i] = (string)$i;
        }
        
        return $dias;
    }

    private function getMeses()
    {
        $meses = $this->anteponerCeroADigitos();

        for ($i=10; $i<13; $i++)
        {
            $meses[(string)$i] = (string)$i;
        }
        
        return $meses;
    }

    private function getAnios()
    {   
        $anioDesde = date("Y")-10;
        $anioHasta = date("Y");

        for ($i=$anioDesde; $i<=$anioHasta; $i++)
        {
            $anios[$i] = $i;
        }
        return $anios;
    }

    private function getHoras()
    {
        $horas = $this->anteponerCeroADigitosHora();

        for ($i=10; $i<24; $i++)
        {
            $horas[(string)$i] = (string)$i;
        }
        
        return $horas;
    }

    private function getMinutos()
    {
        $minutos = $this->anteponerCeroADigitosHora();

        for ($i=10; $i<60; $i++)
        {
            $minutos[(string)$i] = (string)$i;
        }
        
        return $minutos;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dia', 'choice', array('label' => 'form.fechaYHoraTurnoType.label.dia', 'choices' => $this->getDias()))
            ->add('mes', 'choice', array('label' => 'form.fechaYHoraTurnoType.label.mes', 'choices' => $this->getMeses()))
            ->add('anio', 'choice', array('label' => 'form.fechaYHoraTurnoType.label.anio', 'choices' => $this->getAnios()))
            ->add('hora', 'choice', array('label' => 'form.fechaYHoraTurnoType.label.hora', 'choices' => $this->getHoras()))
            ->add('minutos', 'choice', array('label' => 'form.fechaYHoraTurnoType.label.minuto', 'choices' => $this->getMinutos()))
            ->add('seleccionar', 'submit', array('label' => 'form.fechaYHoraTurnoType.boton.seleccionar'));
    }

    public function getName()
    {
        return 'fechaYHoraTurno';
    }
}