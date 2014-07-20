<?php
namespace Salita\UsuarioBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\ChangePasswordController as BaseController;
use Salita\UsuarioBundle\Entity\Usuario as Usuario;

class ChangePasswordController extends BaseController
{
    /**
     * Change user password
     */
    public function changePasswordAction()
    {
    	echo("hola");
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) /*|| !$user instanceof UserInterface*/) {
        	echo("hola.1");
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        echo("hola2");
        $form = $this->container->get('fos_user.change_password.form');
        $formHandler = $this->container->get('fos_user.change_password.form.handler');
        echo("hola3");
        $process = $formHandler->process($user);
        if ($process) {
            $this->container->get('session')->set('mensaje', 'El cambio de contraseña ha sido realizado con éxito');
            $action = 'resultado_operacion_usuario';
            return new RedirectResponse($this->getRedirectionUrl($action));
        }
        echo("hola4");
        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:ChangePassword:changePassword.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView())
        );
    }
}