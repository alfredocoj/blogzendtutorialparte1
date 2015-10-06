<?php

namespace Core\Util;

use BscTatico\Utils\Constantes;
use stdClass;

class SessionUsuario
{
    private $session;
    private $usuario;

    /**
     * Verifica se o usuário é administrador
     * @param mixed $usuario O objeto contendo as informações do usuário.
     * @return boolean se é ou não administrador.
     */
    public function isAdmin( stdClass $usuario ) {

        //Verificando o usuário. Se ele for administrador, retornamos true.
        return ($usuario->prfId == 1 || $usuario->prfId == 2 || $usuario->prfId == 5) ? true : false;
    }

}
