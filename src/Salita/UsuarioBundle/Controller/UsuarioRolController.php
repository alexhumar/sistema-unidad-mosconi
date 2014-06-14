<?php
namespace Salita\UsuarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\MisRoles;
use Salita\UsuarioBundle\Entity\Rol;
use Salita\UsuarioBundle\Clases\RolTemporal;
use Salita\UsuarioBundle\Form\Type\RolType;
use Salita\OtrosBundle\Clases\ConsultaRol;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UsuarioRolController extends Controller
{
    private function getSessionUser()
    {
    	return $this->container->get('security.context')->getToken()->getUser();
    }
    
    private function getEntityManager()
    {
    	return $this->get('repos_manager')->getEntityManager();
    }
	
public function elegirAction(Request $request)
    {
       $repoRoles = $this->get('repos_manager')->getRolesRepo();
       $repoUsuarios = $this->get('repos_manager')->getUsuariosRepo();
       $usuario = $this->getSessionUser();
       $usuario = $repoUsuarios->find($usuario->getId());
       $session = $request->getSession();
       $session->set('usuario', $usuario);
       if(($usuario->isAdministrador()) and ($usuario->isMedico()))
       {
           /*Prepara el formulario para la seleccion de rol (O rol medico o rol administrador)*/
           $roles = $repoRoles->rolesAdministradorYMedico();
           $rolTemp = new RolTemporal();
           $form = $this->createForm(new RolType($roles), $rolTemp);
           if ($request->getMethod() == 'POST')
           {
               $form->handleRequest($request);
               if ($form->isValid())
               {
                   $rolSeleccionado = $repoRoles->findOneByCodigo($rolTemp->getNombre());
                   $session->set('rolSeleccionado', $rolSeleccionado);
               }
           }
           else
           {
               return $this->render(
               			'SalitaUsuarioBundle:EleccionRolForm:eleccionRol.html.twig',
               			array('form' => $form->createView())
               		);
           }
       }
       /*Si no esta seteada la variable de sesion es porque no tiene los dos roles, administrador y medico, juntos.*/
       if (!$session->has('rolSeleccionado'))
       {
           $rolesUsuario = $usuario->getRoles();
           /*Esto es un parche para que seleccione bien el rol de un usuario si es administrador, ya que su primer rol es ROLE_ADMIN, y si se selecciona
           ese rol, crashea la consulta en $repoRoles*/
           if (in_array(Rol::getCodigoRolAdmin(), $rolesUsuario))
           {
               $index = 1;
           }
           else
           {
               $index = 0;
           }
           $rolUsuario = $repoRoles->findOneByCodigo($rolesUsuario[$index]);
           $session->set('rolSeleccionado', $rolUsuario);
       }
       switch (ConsultaRol::rolSeleccionado($session)->getCodigo())
       {
           case Rol::getCodigoRolMedico(): $session->set('especialidad', $usuario->getEspecialidad());
                               return $this->redirect($this->generateUrl('menu_medico'));
                               break;
           case Rol::getCodigoRolSecretaria(): return $this->redirect($this->generateUrl('menu_secretaria'));
                                   break;
           case Rol::getCodigoRolAdministrador(): return $this->redirect($this->generateUrl('menu_administrador'));
                                      break;
       }
    }
}