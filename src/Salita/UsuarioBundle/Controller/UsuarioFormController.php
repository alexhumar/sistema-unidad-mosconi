<?php
namespace Salita\UsuarioBundle\Controller;

use Salita\UsuarioBundle\Form\Type\UsuarioType;
use Salita\UsuarioBundle\Entity\Usuario;
use Salita\UsuarioBundle\Entity\Rol;
use Salita\UsuarioBundle\Entity\Especialidad;
use Salita\UsuarioBundle\Form\Type\RolType;
use Salita\UsuarioBundle\Clases\RolTemporal;
use Salita\UsuarioBundle\Form\Type\EspecialidadUsuarioType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\ConsultaRol;

class UsuarioFormController extends Controller
{
    private function getEntityManager()
    {
        return $this->get('repos_manager')->getEntityManager();
    }
	
	/*Esta funcion encapsula la logica de negocio relacionada a la asignacion de rol a un usuario.
	 * Retona en un boolean si la operacion fue exitosa o no, y almacena en la sesion el string especificando 
	 * el resultado exacto de la operacion.*/
	private function assignRoleToUser($usuario, $rol, $session)
	{
		$exito = false;
		$mensaje = "";
		$codigoRol = $rol->getCodigo();
		if($usuario->hasRole($codigoRol))
		{
			$mensaje = 'El usuario ya tiene el rol que ha elegido';
		}
		else
		{
			if(($usuario->isSecretaria()) && ($rol->isRoleAdministrador()))
			{
				$mensaje = 'Un usuario con rol secretaria no puede ser administrador';
			}
			else
			{
				if(($usuario->isAdministrador()) && ($rol->isRoleSecretaria()))
				{
					$mensaje = 'Un usuario con rol administrador no puede ser secretaria';
				}
				else
				{
					if(($usuario->isMedico()) && ($rol->isRoleSecretaria()))
					{
						$mensaje = 'Un usuario con rol medico no puede ser secretaria';
					}
					else
					{
						if(($usuario->isSecretaria()) && ($rol->isRoleMedico()))
						{
							$mensaje = 'Un usuario con rol secretaria no puede ser medico';
						}
						else
						{
							$this->get('persistence_manager')->assignRolAUsuario($usuario, $rol);
							/*Se "refresca" el usuario almacenado en la sesion*/
							$session->set('usuarioSeleccionado',$usuario);
							$exito = true;
							$mensaje = 'El rol se asigno exitosamente al usuario';
						}
					}
				}
			}
		}
		$session->set('mensaje_asignacion_rol', $mensaje);
		return $exito;
	}

    public function listUsuarioAction(Request $request)
    {
        $repoUsuarios = $this->get('repos_manager')->getUsuariosRepo();
        $usuarios = $repoUsuarios->encontrarUsuariosOrdenadosPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listado.html.twig',
        			array('usuarios' => $usuarios)
        		);
    }

    public function listSecretariaAction(Request $request)
    {
    	$repoUsuarios = $this->get('repos_manager')->getUsuariosRepo();
        $secretarias = $repoUsuarios->encontrarSecretariasOrdenadasPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listadoSecretarias.html.twig',
        			array('usuarios' => $secretarias)
        		);
    }

    public function listAdministradorAction(Request $request)
    {
        $repoUsuarios = $this->get('repos_manager')->getUsuariosRepo();
        $administradores = $repoUsuarios->encontrarAdministradoresOrdenadosPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listadoAdministradores.html.twig',
        			array('usuarios' => $administradores)
        		);
    }

    public function listMedicoAction(Request $request)
    {
        $repoUsuarios = $this->get('repos_manager')->getUsuariosRepo();
        $medicos = $repoUsuarios->encontrarMedicosOrdenadosPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listadoMedicos.html.twig',
        			array('usuarios' => $medicos)
        		);
    }
    
    /*Modificacion de algun usuario (fase GET)*/
    public function modifAction(Request $request, $id)
    {
    	$repoUsuarios = $this->get('repos_manager')->getUsuariosRepo();
    	$usuario = $repoUsuarios->find($id);
    	/*Si no existe el usuario*/
    	if(!$usuario)
    	{
    		throw $this->createNotFoundException("El usuario no existe");
    	}
    	$form = $this->createForm(new UsuarioType(),$usuario);
    	return $this->render(
    			'SalitaUsuarioBundle:UsuarioForm:modif.html.twig',
    			array('form' => $form->createView(),'id' => $id)
    	);
    }
    
    /*Modificacion de algun usuario (fase POST)*/
    public function modifProcessAction(Request $request, $id)
    {
    	$repoUsuarios = $this->get('repos_manager')->getUsuariosRepo();
    	$usuario = $repoUsuarios->find($id);
    	/*Si no existe el usuario*/
    	if(!$usuario)
    	{
    		throw $this->createNotFoundException("El usuario no existe");
    	}
    	$form = $this->createForm(new UsuarioType(),$usuario);
    	$form->handleRequest($request);
    	$session = $request->getSession();
    	if ($form->isValid())
    	{
    		$em = $this->getEntityManager();
    		$em->flush();
    		$mensaje = 'Los datos del usuario fueron modificados exitosamente';	
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al intentar modificar los datos del usuario';
    	}
    	$session->set('mensaje', $mensaje);
    	return $this->redirect($this->generateUrl('resultado_operacion_usuario'));
    }

    /*Modificacion de usuario propio (fase GET)*/
    public function modifPropioAction(Request $request)
    {
        $session = $request->getSession();
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	$usuario = $this->get('persistence_manager')->getRepoUserFromSessionUser($session->get('usuario'));
    	$form = $this->createForm(new UsuarioType(), $usuario);
    	return $this->render(
    				'SalitaUsuarioBundle:UsuarioForm:modifPropio.html.twig',
    				array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo())
    			);
    }

    /*Modificacion de usuario propio (fase POST)*/
    public function modifPropioProcessAction(Request $request)
    {
        $session = $request->getSession();
    	$usuario = $this->get('persistence_manager')->getRepoUserFromSessionUser($session->get('usuario'));
        $form = $this->createForm(new UsuarioType(), $usuario);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
            $em = $this->getEntityManager();
            $em->flush();
            /*Se "refresca" el usuario almacenado en la sesion*/
    	    $session->set('usuario', $usuario);
    	    $mensaje = 'Sus datos fueron modificados exitosamente';
    	}
    	else
    	{
    		$mensaje = 'Se produjo un error al intentar modificar sus datos';
    	}
    	$session->set('mensaje', $mensaje);
    	return $this->redirect($this->generateUrl('resultado_operacion_usuario'));
    }

    public function delSecretariaAction(Request $request, $id)
    {
        $repoUsuarios = $this->get('repos_manager')->getUsuariosRepo();
        $usuario = $repoUsuarios->find($id);
        /*Si no existe el usuario*/
        if (!$usuario)
        {
        	throw $this->createNotFoundException("El usuario no existe");
        }
        $this->get('persistence_manager')->removeUsuario($usuario);
        return $this->redirect($this->generateUrl('listado_secretaria'));
    }

    public function delMedicoAction(Request $request, $id)
    {
        $repoUsuarios = $this->get('repos_manager')->getUsuariosRepo();
        $repoRoles = $this->get('repos_manager')->getRolesRepo();
        $usuario = $repoUsuarios->find($id);
        /*Si no existe el usuario*/
        if(!$usuario)
        {
        	throw $this->createNotFoundException("El usuario no existe");
        }
        /*Si el usuario solamente es medico, lo deshabilita*/
        if(!$usuario->isAdministrador())
        {
        	$usuario->setEnabled(false);
        }
        $rol = $repoRoles->findOneByCodigo(Rol::getCodigoRolMedico());
        $this->get('persistence_manager')->removeRolAUsuario($usuario, $rol);
        return $this->redirect($this->generateUrl('listado_medico'));   
    }

    public function delAdministradorAction(Request $request, $id)
    {
        
        $repoUsuarios = $this->get('repos_manager')->getUsuariosRepo();
        $repoRoles = $this->get('repos_manager')->getRolesRepo();
        $usuario = $repoUsuarios->find($id);
        if(!$usuario)
        {
        	throw $this->createNotFoundException("El usuario no existe");
        }
        /*Si el usuario es solamente administrador*/
        if(!$usuario->isMedico())
        {
            $usuario->setEnabled(false);
        }
        $rol = $repoRoles->findOneByCodigo(Rol::getCodigoRolAdministrador());
        $this->get('persistence_manager')->removeRolAUsuario($usuario, $rol);
        return $this->redirect($this->generateUrl('listado_administrador')); 
    }
    
    /*Asignacion de rol a usuario (fase GET)*/
    public function asignarRolAction(Request $request)
    {
    	$repoRoles = $this->get('repos_manager')->getRolesRepo();
    	$roles = $repoRoles->findAll();
    	$rolTemp = new RolTemporal();
    	/*Crea un formulario con un combo box con los roles existentes para asignar al usuario.
    	 *El rol seleccionado queda cargado en un objeto de clase RolTemporal.*/
    	$form = $this->createForm(new RolType($roles), $rolTemp);
    	return $this->render(
    				'SalitaUsuarioBundle:UsuarioForm:asignacionRol.html.twig',
    				array('form' => $form->createView())
    			);
    }
    
    /*Asignacion de rol a usuario (fase POST)*/
    public function asignarRolProcessAction(Request $request)
    {
    	$repoRoles = $this->get('repos_manager')->getRolesRepo();
    	$roles = $repoRoles->findAll();
    	$rolTemp = new RolTemporal();
    	$form = $this->createForm(new RolType($roles), $rolTemp);
   		$form->handleRequest($request);
   		$session = $request->getSession();
   		if ($form->isValid())
   		{
   			$rolElegido = $repoRoles->findOneByCodigo($rolTemp->getNombre());
   			if (!$session->has('usuarioSeleccionado')) 
   			{
   				return $this->redirect($this->generateUrl('listado_usuario'));
   			}
   			$usuario = $this->get('persistence_manager')->getRepoUserFromSessionUser($session->get('usuarioSeleccionado'));
   			/*Asigna el rol elegido al usuario y retorna un mensaje en base al resultado de las validaciones*/
			if ($this->assignRoleToUser($usuario, $rolElegido, $session))
			{
				/*Si se asigno exitosamente el rol y el rol elejido fue el de medico, debe asignarse la especialidad*/
				if($rolElegido->getCodigo() == Rol::getCodigoRolMedico())
				{
					return $this->redirect($this->generateUrl('asignacion_especialidad'));
				}
			}
			$mensaje = $session->get('mensaje_asignacion_rol');
    	}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar asignar un rol al usuario';
   		}
   		$session->set('mensaje', $mensaje);
   		return $this->redirect($this->generateUrl('resultado_operacion_usuario'));
    }
        
    /*Asignacion de especialidad a usuario medico (fase GET)*/
    public function asignarEspecialidadAction(Request $request)
    {
    	$session = $request->getSession();
    	if($session->has('usuarioSeleccionado'))
    	{
    		$usuario = $this->get('persistence_manager')->getRepoUserFromSessionUser($session->get('usuarioSeleccionado'));
    	}
    	else
    	{
    		return $this->redirect($this->generateUrl('listado_usuario'));
    	}
    	if ($usuario->isMedico())
    	{
    		$form = $this->createForm(new EspecialidadUsuarioType(), $usuario);
   			return $this->render(
   						'SalitaUsuarioBundle:UsuarioForm:asignacionEspecialidad.html.twig',
   						array('form' => $form->createView())
   					);
    	}
    	else
    	{
    		$mensaje = 'El usuario no es un medico';
    		$session->set('mensaje', $mensaje);
    		return $this->redirect($this->generateUrl('resultado_operacion_usuario'));
    	}
    }
    
    /*Asignacion de especialidad a usuario medico (fase POST)*/
    public function asignarEspecialidadProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	if($session->has('usuarioSeleccionado'))
    	{
    		$usuario = $this->get('persistence_manager')->getRepoUserFromSessionUser($session->get('usuarioSeleccionado'));
    	}
    	else
    	{
    		return $this->redirect($this->generateUrl('listado_usuario'));
    	}
    	if ($usuario->isMedico())
    	{
    		$form = $this->createForm(new EspecialidadUsuarioType(), $usuario);
    		$form->handleRequest($request);
    		if ($form->isValid())
    		{
    			$em = $this->getEntityManager();
    			$em->flush();
    			$session->remove('usuarioSeleccionado');
    			$mensaje = 'La especialidad fue asignada exitosamente al medico';	
    		}
    		else
    		{
    			$mensaje = 'Se produjo un error al intentar asignar una especialidad al medico';
    		}
    	}
    	else
    	{
    		$mensaje = 'El usuario no es medico';
    	}
    	$session->set('mensaje', $mensaje);
    	return $this->redirect($this->generateUrl('resultado_operacion_usuario'));
    }

    public function seleccionarAction(Request $request, $id)
    {
        $session = $request->getSession();
        $repoUsuarios = $this->get('repos_manager')->getUsuariosRepo();
        $usuario = $repoUsuarios->find($id);
        if(!$usuario)
        {
        	throw $this->createNotFoundException("El usuario no existe");
        }
        /*Usuario seleccionado contiene el usuario al cual se le asignara un rol (y posiblemente especialidad).
         * Se mantiene seteado en la variable de sesion mientras dura el proceso de asignacion de rol.*/
        $session->set('usuarioSeleccionado', $usuario);
        return $this->redirect($this->generateUrl('asignacion_rol'));
    }
}
