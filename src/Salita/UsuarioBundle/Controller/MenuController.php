<?php
namespace Salita\UsuarioBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\MisRoles;

class MenuController extends Controller
{
    public function administradorAction(Request $request)
    {
       return $this->render('SalitaUsuarioBundle:Menu:menuAdministrador.html.twig');
    }

    public function medicoAction(Request $request)
    {
       return $this->render('SalitaUsuarioBundle:Menu:menuMedico.html.twig');
    }

    public function secretariaAction(Request $request)
    {
       return $this->render('SalitaUsuarioBundle:Menu:menuSecretaria.html.twig');
    }
}
