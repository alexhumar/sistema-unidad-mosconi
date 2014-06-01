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
        return $this->getDoctrine()->getEntityManager();
    }
    
    private function getRolesRepo()
    {
    	$em = $this->getEntityManager();
    	return $em->getRepository('SalitaUsuarioBundle:Rol');
    }

	private function getUsersRepo()
	{
		$em = $this->getEntityManager();
        return $em->getRepository('SalitaUsuarioBundle:Usuario');
	}
	
        private function getRepoUserFromSessionUser($session)
	{
		$repoUsuarios = $this->getUsersRepo();
		$usuario = $session->get('usuario');
		$usuario = $repoUsuarios->findOneById($usuario->getId());
		return $usuario;
	}
	
	/*Esta funcion encapsula la logica de negocio relacionada a la asignacion de rol a un usuario.
	 * Retona en un boolean si la operacion fue exitosa o no, y devuelve en el parametro "mensaje"
	 * el string especificando el resultado exacto de la operacion.*/
	private function assignRoleToUser($usuario, $rol, $mensaje)
	{
		$exito = false;
		
		if($usuario->hasRole($rol->getCodigo()))
		{
			$mensaje = 'El usuario ya tiene el rol que ha elegido';
		}
		else
		{
			if(($usuario->hasRole('ROLE_SECRETARIA')) && ($rol->getCodigo() == 'ROLE_ADMINISTRADOR'))
			{
				$mensaje = 'Un usuario con rol secretaria no puede ser administrador';
			}
			else
			{
				if(($usuario->hasRole('ROLE_ADMINISTRADOR')) && ($rol->getCodigo() == 'ROLE_SECRETARIA'))
				{
					$mensaje = 'Un usuario con rol administrador no puede ser secretaria';
				}
				else
				{
					if(($usuario->hasRole('ROLE_MEDICO')) && ($rol->getCodigo() == 'ROLE_SECRETARIA'))
					{
						$mensaje = 'Un usuario con rol medico no puede ser secretaria';
					}
					else
					{
						if(($usuario->hasRole('ROLE_SECRETARIA')) && ($rol->getCodigo() == 'ROLE_MEDICO'))
						{
							$mensaje = 'Un usuario con rol secretaria no puede ser medico';
						}
						else
						{
							$usuario->setEnabled(true);
							$em = $this->getEntityManager();
							$em->persist($usuario);
							$em->flush();
							$exito = true;
							$mensaje = 'El rol se asigno exitosamente al usuario';
						}
					}
				}
			}
		}
		return $exito;
	}

    public function listUsuarioAction(Request $request)
    {
        $repoUsuarios = $this->getUsersRepo();
        $usuarios = $repoUsuarios->encontrarUsuariosOrdenadosPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listado.html.twig',
        			array('usuarios' => $usuarios)
        		);
    }

    public function listSecretariaAction(Request $request)
    {
    	$repoUsuarios = $this->getUsersRepo();
        $secretarias = $repoUsuarios->encontrarSecretariasOrdenadasPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listadoSecretarias.html.twig',
        			array('usuarios' => $secretarias)
        		);
    }

    public function listAdministradorAction(Request $request)
    {
        $repoUsuarios = $this->getUsersRepo();
        $administradores = $repoUsuarios->encontrarAdministradoresOrdenadosPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listadoAdministradores.html.twig',
        			array('usuarios' => $administradores)
        		);
    }

    public function listMedicoAction(Request $request)
    {
        $repoUsuarios = $this->getUsersRepo();
        $medicos = $repoUsuarios->encontrarMedicosOrdenadosPorNombre();
        return $this->render(
        			'SalitaUsuarioBundle:UsuarioForm:listadoMedicos.html.twig',
        			array('usuarios' => $medicos)
        		);
    }
    
    /*Modificacion de algun usuario (fase GET)*/
    public function modifAction(Request $request, $id)
    {
    	$repoUsuarios = $this->getUsersRepo();
    	$usuario = $repoUsuarios->findOneById($id);
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
    	$repoUsuarios = $this->getUsersRepo();
    	$usuario = $repoUsuarios->findOneById($id);
    	/*Si no existe el usuario*/
    	if(!$usuario)
    	{
    		throw $this->createNotFoundException("El usuario no existe");
    	}
    	$form = $this->createForm(new UsuarioType(),$usuario);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getEntityManager();
    		/*Ojo: esta linea puede que sea motivo de falla*/
    		$em->persist($usuario);
    		$em->flush();
    		return $this->render(
    				'SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig',
    				array('mensaje' => 'Los datos del usuario fueron modificados exitosamente')
    		);
    	}
    	else
    	{
    		return $this->render(
    				'SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig',
    				array('mensaje' => 'Se produjo un error al intentar modificar los datos del usuario')
    		);
    	}		
    }

    /*Modificacion de usuario propio (fase GET)*/
    public function modifPropioAction(Request $request)
    {
        $session = $request->getSession();
    	$rolSeleccionado = ConsultaRol::rolSeleccionado($session);
    	$usuario = $this->getRepoUserFromSessionUser($session);
    	$form = $this->createForm(new UsuarioType(), $usuario);
    	return $this->render(
    				'SalitaUsuarioBundle:UsuarioForm:modifPropio.html.twig',
    				array('form' => $form->createView(),'rol' => $rolSeleccionado->getCodigo())
    			);
    }

    /*Modificacion de usuario propio (fase POST)*/
    public function modifPropioProcessAction(Request $request)
    {
        $em = $this->getEntityManager();
        $session = $request->getSession();
    	$usuario = $this->getRepoUserFromSessionUser($session);
        $form = $this->createForm(new UsuarioType(), $usuario);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
            $em = $this->getEntityManager();
            $em->flush();
    	    $session->set('usuario', $usuario);
            return $this->render(
    				'SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig',
    				array('mensaje' => 'Sus datos fueron modificados exitosamente')
    			  );
    	}
    	else
    	{
    		return $this->render(
    				'SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig',
    				array('mensaje' => 'Se produjo un error al intentar modificar sus datos')
    			);
    	}
    }

    public function delSecretariaAction(Request $request, $id)
    {
    	$em = $this->getEntityManager();
        $repoUsuarios = $this->getUsersRepo();
        $usuario = $repoUsuarios->find($id);
        /*Si no existe el usuario*/
        if (!$usuario)
        {
        	throw $this->createNotFoundException("El usuario no existe");
        }
        $em->remove($usuario);
        $em->flush();
        return $this->redirect($this->generateUrl('listado_secretaria'));
    }

    public function delMedicoAction(Request $request, $id)
    {
        $em = $this->getEntityManager();
        $repoUsuarios = $this->getUsersRepo();
        $repoRoles = $this->getRolesRepo();
        $usuario = $repoUsuarios->find($id);
        /*Si no existe el usuario*/
        if(!$usuario)
        {
        	throw $this->createNotFoundException("El usuario no existe");
        }
        /*Si el usuario solamente es medico, lo deshabilita*/
        if(!$usuario->hasRole('ROLE_ADMINISTRADOR'))
        {
        	$usuario->setEnabled(false);
        }
        $rol = $repoRoles->findOneByCodigo("'ROLE_MEDICO'");
        $usuario->quitarRol($rol);
        /*Guarda con esta linea de codigo...*/
        $em->persist($usuario);
        $em->flush();
        return $this->redirect($this->generateUrl('listado_medico'));   
    }

    public function delAdministradorAction(Request $request, $id)
    {
        $em = $this->getEntityManager();
        $repoUsuarios = $this->getUsersRepo();
        $repoRoles = $this->getRolesRepo();
        $usuario = $repoUsuarios->find($id);
        if(!$usuario)
        {
        	throw $this->createNotFoundException("El usuario no existe");
        }
        /*Si el usuario es solamente administrador*/
        if(!$usuario->hasRole('ROLE_MEDICO'))
        {
            $usuario->setEnabled(false);
        }
        $rol = $repoRoles->findOneByCodigo("'ROLE_ADMINISTRADOR'");
        $usuario->quitarRol($rol);
        /*Guarda con esta linea de codigo...*/
        $em->persist($usuario);    
        $em->flush();
        return $this->redirect($this->generateUrl('listado_administrador')); 
    }

/*    public function asignarRolAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repoRoles = $em->getRepository('SalitaUsuarioBundle:Rol');
        $roles = $repoRoles->findAll();
        $rolTemp = new RolTemporal();  
        $form = $this->createForm(new RolType($roles), $rolTemp);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            if ($form->isValid())
            {
                $rolElegido = $repoRoles->findOneByCodigo($rolTemp->getNombre());
                $usuario = $session->get('usuarioSeleccionado');
                if($usuario->hasRole($rolElegido->getCodigo()))
                {
                    $mensaje = 'El usuario ya tiene el rol que ha elegido';
                }
                else
                {
                    if(($usuario->hasRole('ROLE_SECRETARIA')) && ($rolElegido->getCodigo() == 'ROLE_ADMINISTRADOR'))
                    {
                        $mensaje = 'Un usuario con rol secretaria no puede ser administrador';
                    }
                    else
                    {
                        if(($usuario->hasRole('ROLE_ADMINISTRADOR')) && ($rolElegido->getCodigo() == 'ROLE_SECRETARIA'))
                        {
                            $mensaje = 'Un usuario con rol administrador no puede ser secretaria';
                        }
                        else
                        {
                            if(($usuario->hasRole('ROLE_MEDICO')) && ($rolElegido->getCodigo() == 'ROLE_SECRETARIA'))
                            {
                                $mensaje = 'Un usuario con rol medico no puede ser secretaria'; 
                            }
                            else
                            {
                                if(($usuario->hasRole('ROLE_SECRETARIA')) && ($rolElegido->getCodigo() == 'ROLE_MEDICO'))
                                {
                                    $mensaje = 'Un usuario con rol secretaria no puede ser medico';
                                }
                                else
                                {
                                    $mensaje = 'El rol se asigno exitosamente al usuario';
                                    $usuario->setEnabled(true);
                                    $em->persist($usuario);
                                    $em->flush();
                                    if($rolElegido->getCodigo() == 'ROLE_MEDICO')
                                    {
                                        return $this->redirect($this->generateUrl('asignacion_especialidad')); 
                                    }
                                }
                            }
                        }
                    }    
                }   

                return $this->render('SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig', array('mensaje' => $mensaje,
            ));
            }
            else 
            {
                $mensaje = 'Se produjo un error al intentar asignar un rol al usuario';
                return $this->render('SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig', array('mensaje' => $mensaje,
            ));
            }            
        }
        else
        {
            return $this->render('SalitaUsuarioBundle:UsuarioForm:asignacionRol.html.twig', array('form' => $form->createView(),));
        }
    }*/
    
    /*Asignacion de rol a usuario (fase GET)*/
    public function asignarRolAction(Request $request)
    {
    	$repoRoles = $this->getRolesRepo();
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
    	$repoRoles = $this->getRolesRepo();
    	$roles = $repoRoles->findAll();
    	$rolTemp = new RolTemporal();
    	$form = $this->createForm(new RolType($roles), $rolTemp);
   		$form->handleRequest($request);
   		if ($form->isValid())
   		{
   			$session = $request->getSession();
   			$rolElegido = $repoRoles->findOneByCodigo($rolTemp->getNombre());
   			$usuario = $session->get('usuarioSeleccionado');
   			/*Asigna el rol elegido al usuario y retorna un mensaje en base al resultado de las validaciones*/
   			$mensaje = "";
			if ($this->assignRoleToUser($usuario, $rolElegido, $mensaje))
			{
				/*Si se asigno exitosamente el rol y el rol elejido fue el de medico, debe asignarse la especialidad*/
				if($rolElegido->getCodigo() == 'ROLE_MEDICO')
				{
					return $this->redirect($this->generateUrl('asignacion_especialidad'));
				}
			}
   			return $this->render(
   						'SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig',
   						array('mensaje' => $mensaje)
   					);
    	}
   		else
   		{
   			$mensaje = 'Se produjo un error al intentar asignar un rol al usuario';
   			return $this->render(
   						'SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig',
   						array('mensaje' => $mensaje)
   					);
   		}
    }
    
    /*public function asignarEspecialidadAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getEntityManager();
        if($session->has('usuarioSeleccionado'))
        {
            $usuario = $session->get('usuarioSeleccionado');
        }
        else
        {
            return $this->redirect($this->generateUrl('listado_usuario'));
        }
        if ($usuario->hasRole('ROLE_MEDICO'))
        {
            $form = $this->createForm(new EspecialidadUsuarioType(), $usuario);
            if ($request->getMethod() == 'POST')
            {
                $form->bindRequest($request);
                if ($form->isValid())
                {
                    $em->persist($usuario);
                    $em->flush();
                    $session->remove('usuarioSeleccionado');
                    $mensaje = 'La especialidad fue asignada exitosamente al medico';
                    return $this->render('SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig', array('mensaje' => $mensaje,
                    ));
                }
                else 
                {
                    $mensaje = 'Se produjo un error al intentar asignar una especialidad al medico';
                    return $this->render('SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig', array('mensaje' => $mensaje,
                    ));
                }            
            }
            else
            {
                return $this->render('SalitaUsuarioBundle:UsuarioForm:asignacionEspecialidad.html.twig', array('form' => $form->createView(),));
            }
        }
        else
        {
            $mensaje = 'El usuario no es un medico';
            return $this->render('SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig', array('mensaje' => $mensaje,
            ));           
        }
    }*/
    
    /*Asignacion de especialidad a usuario medico (fase GET)*/
    public function asignarEspecialidadAction(Request $request)
    {
    	$session = $request->getSession();
    	$em = $this->getEntityManager();
    	if($session->has('usuarioSeleccionado'))
    	{
    		$usuario = $session->get('usuarioSeleccionado');
    	}
    	else
    	{
    		return $this->redirect($this->generateUrl('listado_usuario'));
    	}
    	if ($usuario->hasRole('ROLE_MEDICO'))
    	{
    		$form = $this->createForm(new EspecialidadUsuarioType(), $usuario);
    		if ($request->getMethod() == 'POST')
    		{
    			$form->bindRequest($request);
    			if ($form->isValid())
    			{
    				$em->persist($usuario);
    				$em->flush();
    				$session->remove('usuarioSeleccionado');
    				$mensaje = 'La especialidad fue asignada exitosamente al medico';
    				return $this->render('SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig', array('mensaje' => $mensaje,
    				));
    			}
    			else
    			{
    				$mensaje = 'Se produjo un error al intentar asignar una especialidad al medico';
    				return $this->render('SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig', array('mensaje' => $mensaje,
    				));
    			}
    		}
    		else
    		{
    			return $this->render('SalitaUsuarioBundle:UsuarioForm:asignacionEspecialidad.html.twig', array('form' => $form->createView(),));
    		}
    	}
    	else
    	{
    		$mensaje = 'El usuario no es un medico';
    		return $this->render('SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig', array('mensaje' => $mensaje,
    		));
    	}
    }
    
    /*Asignacion de especialidad a usuario medico (fase POST)*/
    public function asignarEspecialidadProcessAction(Request $request)
    {
    	$session = $request->getSession();
    	$em = $this->getEntityManager();
    	if($session->has('usuarioSeleccionado'))
    	{
    		$usuario = $session->get('usuarioSeleccionado');
    	}
    	else
    	{
    		return $this->redirect($this->generateUrl('listado_usuario'));
    	}
    	if ($usuario->hasRole('ROLE_MEDICO'))
    	{
    		$form = $this->createForm(new EspecialidadUsuarioType(), $usuario);
    		if ($request->getMethod() == 'POST')
    		{
    			$form->bindRequest($request);
    			if ($form->isValid())
    			{
    				$em->persist($usuario);
    				$em->flush();
    				$session->remove('usuarioSeleccionado');
    				$mensaje = 'La especialidad fue asignada exitosamente al medico';
    				return $this->render('SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig', array('mensaje' => $mensaje,
    				));
    			}
    			else
    			{
    				$mensaje = 'Se produjo un error al intentar asignar una especialidad al medico';
    				return $this->render('SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig', array('mensaje' => $mensaje,
    				));
    			}
    		}
    		else
    		{
    			return $this->render('SalitaUsuarioBundle:UsuarioForm:asignacionEspecialidad.html.twig', array('form' => $form->createView(),));
    		}
    	}
    	else
    	{
    		$mensaje = 'El usuario no es un medico';
    		return $this->render('SalitaUsuarioBundle:UsuarioForm:mensaje.html.twig', array('mensaje' => $mensaje,
    		));
    	}
    }

    public function seleccionarAction(Request $request, $id)
    {
        $session = $request->getSession();
        $repoUsuarios = $this->getUsersRepo();
        $usuario = $repoUsuarios->findOneById($id);
        if(!$usuario)
        {
        	throw $this->createNotFoundException("El usuario no existe");
        }
        $session->set('usuarioSeleccionado', $usuario);
        return $this->redirect($this->generateUrl('asignacion_rol'));
    }
}
