<?php
namespace Salita\UsuarioBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\MisRoles;
use Salita\UsuarioBundle\Clases\RolTemporal;
use Salita\UsuarioBundle\Form\Type\RolType;
use Salita\OtrosBundle\Clases\ConsultaRol;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
//despues de revisarlo llegue a la conclusion de que: 1-La variable de sesion funciona. 2-El objeto usuario queda cargado en la sesion.
//3-El rol seleccionado queda bien cargado en la sesion (si no lo elegis, si lo elegis no lo probe).


//ATENCION!!: me parece que tengo que cargar el usuario en la sesion a partir de una consulta por id porque creo que me esta cargando solo los datos de la superclase!! Me fui a comer... Acordate que tenias abierto el UsuarioFormController.php
class UsuarioRolController extends Controller
{
    public function elegirAction(Request $request)
    {
       $em = $this->getDoctrine()->getEntityManager();
       $repoRoles = $em->getRepository('SalitaUsuarioBundle:Rol');
       $repoUsuarios = $em->getRepository('SalitaUsuarioBundle:Usuario');
       $usuario = $this->container->get('security.context')->getToken()->getUser();
       $usuario = $repoUsuarios->findOneById($usuario->getId());
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
               return $this->render('SalitaUsuarioBundle:EleccionRolForm:eleccionRol.html.twig', array('form' => $form->createView(),));
           }
       }
       /*Si no esta seteada la variable de sesion es porque no tiene los dos roles, administrador y medico, juntos.*/
       if (!$session->has('rolSeleccionado'))
       {
           $rolesUsuario = $usuario->getRoles();
           /*Esto es un parche para que seleccione bien el rol de un usuario si es administrador, ya que su primer rol es ROLE_ADMIN, y si se selecciona
           ese rol, crashea la consulta en $repoRoles*/
           if (in_array('ROLE_ADMIN', $rolesUsuario))
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
           case 'ROLE_MEDICO': $session->set('especialidad', $usuario->getEspecialidad());
                               return $this->redirect($this->generateUrl('menu_medico'));
                               break;
           case 'ROLE_SECRETARIA': return $this->redirect($this->generateUrl('menu_secretaria'));
                                   break;
           case 'ROLE_ADMINISTRADOR': return $this->redirect($this->generateUrl('menu_administrador'));
                                      break;
       }
    }
}
