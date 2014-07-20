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
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->container->get('fos_user.change_password.form');
        $formHandler = $this->container->get('fos_user.change_password.form.handler');

        $process = $formHandler->process($user);
        if ($process) {
            $this->container->get('session')->set('mensaje', 'El cambio de contraseña ha sido realizado con éxito');
            $action = 'resultado_operacion_usuario';
            return new RedirectResponse($this->getRedirectionUrl($action));
        }

        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:ChangePassword:changePassword.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView(), 'theme' => $this->container->getParameter('fos_user.template.theme'))
        );
    }
}