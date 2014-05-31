<?php

namespace Salita\TurnoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SalitaTurnoBundle:Default:index.html.twig', array('name' => $name));
    }
}
