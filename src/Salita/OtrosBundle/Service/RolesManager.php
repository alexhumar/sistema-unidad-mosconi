<?php
namespace Salita\OtrosBundle\Service;

class RolesManager
{
	
	/*Esta funcion encapsula la logica de negocio relacionada a la asignacion de rol a un usuario.
	 * Retona en un boolean si la operacion fue exitosa o no, y almacena en la sesion el string especificando
	* el resultado exacto de la operacion.*/
	public function assignRoleToUser($usuario, $rol, $session)
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
}