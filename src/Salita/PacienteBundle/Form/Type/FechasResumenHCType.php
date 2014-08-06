<?php

namespace Salita\PacienteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FechasResumenHCType extends AbstractType
{

    private function anteponerCeroADigitos()
    {
        for ($i=1;$i<=9;$i++)
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('diaDesde', 'choice', array('label' => 'form.fechasResumenHCType.label.desdeDia', 'choices' => $this->getDias()))
            ->add('mesDesde', 'choice', array('label' => 'form.fechasResumenHCType.label.desdeMes', 'choices' => $this->getMeses()))
            ->add('anioDesde', 'choice', array('label' => 'form.fechasResumenHCType.label.desdeAnio', 'choices' => $this->getAnios()))
            ->add('diaHasta', 'choice', array('label' => 'form.fechasResumenHCType.label.hastaDia', 'choices' => $this->getDias()))
            ->add('mesHasta', 'choice', array('label' => 'form.fechasResumenHCType.label.hastaMes', 'choices' => $this->getMeses()))
            ->add('anioHasta', 'choice', array('label' => 'form.fechasResumenHCType.label.hastaAnio', 'choices' => $this->getAnios()))
            ->add('generar', 'submit', array('label' => 'form.fechasResumenHCType.boton.generar'));
    }

    public function getName()
    {
        return 'fechasResumenHC';
    }
}