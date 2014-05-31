<?php

namespace Salita\PacienteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('SalitaPacienteBundle:Default:index.html.twig', array('name' => $name));
    }
}
