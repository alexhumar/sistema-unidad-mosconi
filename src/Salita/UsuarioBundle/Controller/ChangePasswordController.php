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
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $form = $this->container->get('fos_user.change_password.form');
        $formHandler = $this->container->get('fos_user.change_password.form.handler');
        $process = $formHandler->process($user);
        if ($process) {
        	echo("hola");
            $this->container->get('session')->set('mensaje', 'El cambio de contraseña ha sido realizado con éxito');
            echo("hola1");
            $nextAction = 'resultado_operacion_usuario';
            echo("hola2");
            return new RedirectResponse(/*$this->getRedirectionUrl($action)*/$this->container->get('router')->generate($nextAction));
        }
        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:ChangePassword:changePassword.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView())
        );
    }
}