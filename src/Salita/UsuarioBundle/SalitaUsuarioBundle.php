<?php

namespace Salita\UsuarioBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SalitaUsuarioBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
