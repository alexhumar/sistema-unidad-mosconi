<?php

namespace Salita\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SalitaUsuarioBundle:Default:index.html.twig', array('name' => $name));
    }
}
