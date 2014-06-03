<?php
namespace Salita\UsuarioBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\MisRoles;

class MenuController extends Controller
{
    public function administradorAction()
    {
       return $this->render('SalitaUsuarioBundle:Menu:menuAdministrador.html.twig');
    }

    public function medicoAction()
    {
       return $this->render('SalitaUsuarioBundle:Menu:menuMedico.html.twig');
    }

    public function secretariaAction()
    {
       return $this->render('SalitaUsuarioBundle:Menu:menuSecretaria.html.twig');
    }
}
