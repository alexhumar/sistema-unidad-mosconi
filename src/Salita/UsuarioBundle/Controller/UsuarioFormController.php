<?php
namespace Salita\UsuarioBundle\Controller;

use Salita\UsuarioBundle\Form\Type\UsuarioType;
use Salita\UsuarioBundle\Entity\Usuario;
use Salita\UsuarioBundle\Entity\Rol;
use Salita\UsuarioBundle\Entity\Especialidad;
use Salita\UsuarioBundle\Form\Type\RolType;
use Salita\UsuarioBundle\Clases\RolTemporal;
use Salita\UsuarioBundle\Clases\EspecialidadTemporal;
use Salita\UsuarioBundle\Form\Type\EspecialidadUsuarioType;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Salita\OtrosBundle\Clases\MyController;
use Salita\OtrosBundle\Clases\ConsultaRol;

class UsuarioFormController extends MyController
{
	
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
							$this->getPersistenceManager()->assignRolAUsuario($usuario, $rol);
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

    public function listUsuarioAction()
    {
        $repoUsuarios = $this->getReposManager()->getUsuariosRepo();
        $usuarios = $repoUsuarios->encontrarUsuariosOrdenadosPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listado.html.twig',
        			array('usuarios' => $usuarios)
        		);
    }

    public function listSecretariaAction()
    {
    	$repoUsuarios = $this->getReposManager()->getUsuariosRepo();
        $secretarias = $repoUsuarios->encontrarSecretariasOrdenadasPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listadoSecretarias.html.twig',
        			array('usuarios' => $secretarias)
        		);
    }

    public function listAdministradorAction()
    {
        $repoUsuarios = $this->getReposManager()->getUsuariosRepo();
        $administradores = $repoUsuarios->encontrarAdministradoresOrdenadosPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listadoAdministradores.html.twig',
        			array('usuarios' => $administradores)
        		);
    }

    public function listMedicoAction()
    {
        $repoUsuarios = $this->getReposManager()->getUsuariosRepo();
        $medicos = $repoUsuarios->encontrarMedicosOrdenadosPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listadoMedicos.html.twig',
        			array('usuarios' => $medicos)
        		);
    }
    
    /*Modificacion de algun usuario*/
    public function modifAction($id)
    {
    	$repoUsuarios = $this->getReposManager()->getUsuariosRepo();
    	$usuario = $repoUsuarios->find($id);
    	/*Si no existe el usuario*/
    	if(!$usuario)
    	{
    		throw $this->createNotFoundException("El usuario no existe");
    	}
    	$form = $this->createForm(new UsuarioType(),$usuario);
    	$request = $this->getRequest();
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getEntityManager();
    		$em->flush();
    		$mensaje = 'Los datos del usuario fueron modificados exitosamente';
    		$session = $this->getSession();
    		$session->set('mensaje', $mensaje);
    		return $this->redirect($this->generateUrl('resultado_operacion'));
    	}
    	return $this->render(
    			'SalitaUsuarioBundle:UsuarioForm:modif.html.twig',
    			array('form' => $form->createView(),'id' => $id)
    	);
    }

    /*Modificacion de usuario propio (fase POST)*/
    public function modifPropioAction()
    {
    	$session = $this->getSession();
    	$usuario = $this->getPersistenceManager()->getRepoUserFromSessionUser($session->get('usuario'));
        $form = $this->createForm(new UsuarioType(), $usuario);
        $request = $this->getRequest();
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
            $em = $this->getEntityManager();
            $em->flush();
            /*Se "refresca" el usuario almacenado en la sesion*/
    	    $session->set('usuario', $usuario);
    	    $mensaje = 'Sus datos fueron modificados exitosamente';
    	    $session->set('mensaje', $mensaje);
    	    return $this->redirect($this->generateUrl('resultado_operacion'));
    	}
    	return $this->render(
    				'SalitaUsuarioBundle:UsuarioForm:modifPropio.html.twig',
    				array('form' => $form->createView())
    			);
    }

    public function delSecretariaAction($id)
    {
        $repoUsuarios = $this->getReposManager()->getUsuariosRepo();
        $usuario = $repoUsuarios->find($id);
        /*Si no existe el usuario*/
        if (!$usuario)
        {
        	throw $this->createNotFoundException("El usuario no existe");
        }
        $this->getPersistenceManager()->removeUsuario($usuario);
        return $this->redirect($this->generateUrl('listado_secretaria'));
    }

    public function delMedicoAction($id)
    {
        $repoUsuarios = $this->getReposManager()->getUsuariosRepo();
        $repoRoles = $this->getReposManager()->getRolesRepo();
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
        $this->getPersistenceManager()->removeRolAUsuario($usuario, $rol);
        return $this->redirect($this->generateUrl('listado_medico'));   
    }

    public function delAdministradorAction($id)
    {
        
        $repoUsuarios = $this->getReposManager()->getUsuariosRepo();
        $repoRoles = $this->getReposManager()->getRolesRepo();
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
        $this->getPersistenceManager()->removeRolAUsuario($usuario, $rol);
        return $this->redirect($this->generateUrl('listado_administrador')); 
    }
    
    /*Asignacion de rol a usuario*/
    public function asignarRolAction()
    {
    	$repoRoles = $this->getReposManager()->getRolesRepo();
    	$roles = $repoRoles->findAll();
    	$rolTemp = new RolTemporal();
    	/*Crea un formulario con un combo box con los roles existentes para asignar al usuario.
    	 *El rol seleccionado queda cargado en un objeto de clase RolTemporal.*/
    	$form = $this->createForm(new RolType($roles), $rolTemp);
    	$request = $this->getRequest();
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$rolElegido = $repoRoles->findOneByCodigo($rolTemp->getNombre());
   			$session = $this->getSession();
   			if (!$session->has('usuarioSeleccionado')) 
   			{
   				return $this->redirect($this->generateUrl('listado_usuario'));
   			}
   			$usuario = $this->getPersistenceManager()->getRepoUserFromSessionUser($session->get('usuarioSeleccionado'));
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
			$session->set('mensaje', $mensaje);
			return $this->redirect($this->generateUrl('resultado_operacion'));
    	}
    	return $this->render(
    				'SalitaUsuarioBundle:UsuarioForm:asignacionRol.html.twig',
    				array('form' => $form->createView())
    			);
    }
    
    /*Asignacion de especialidad a usuario medico*/
    public function asignarEspecialidadAction()
    {
    	$session = $this->getSession();
    	if(!$session->has('usuarioSeleccionado'))
    	{
    		return $this->redirect($this->generateUrl('listado_usuario'));
    	}
    	$usuario = $this->getPersistenceManager()->getRepoUserFromSessionUser($session->get('usuarioSeleccionado'));
    	if ($usuario->isMedico())
    	{
    		$form = $this->createForm(new EspecialidadUsuarioType(), $usuario);
    		$request = $this->getRequest();
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
    			return $this->render(
    					'SalitaUsuarioBundle:UsuarioForm:asignacionEspecialidad.html.twig',
    					array('form' => $form->createView())
    			);
    		}
    	}
    	else
    	{
    		$mensaje = 'El usuario no es medico';
    	}
    	$session->set('mensaje', $mensaje);
    	return $this->redirect($this->generateUrl('resultado_operacion'));
    }

    public function seleccionarAction($id)
    {
        $repoUsuarios = $this->getReposManager()->getUsuariosRepo();
        $usuario = $repoUsuarios->find($id);
        if(!$usuario)
        {
        	throw $this->createNotFoundException("El usuario no existe");
        }
        /*Usuario seleccionado contiene el usuario al cual se le asignara un rol (y posiblemente especialidad).
         * Se mantiene seteado en la variable de sesion mientras dura el proceso de asignacion de rol.*/
        $session = $this->getSession();
        $session->set('usuarioSeleccionado', $usuario);
        return $this->redirect($this->generateUrl('asignacion_rol'));
    }
}