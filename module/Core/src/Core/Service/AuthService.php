<?php
namespace Core\Service;

use Zend\Crypt\Password\Bcrypt;
use Core\Util\Constantes;

class AuthService extends BaseService
{
    public function authenticate($params)
    {
        if (!isset($params['usr_usuario']) || $params['usr_usuario'] == '' || !isset($params['usr_senha']) ||  $params['usr_senha'] == '') {
            return false;
        }

        $user = $this->getService(Constantes::MODEL_USUARIO)->getUsuarioAtivo( $params['usr_usuario'] );
        if ( sizeof($user) ) {
            $bcrypt = new Bcrypt();
            $verify = $bcrypt->verify( $params['usr_senha'], $user->usr_senha );

            if ($verify) {
                unset( $user->usr_senha );
                $session = $this->getServiceManager()->get('Session');
                $session->offsetSet('zf2base_loggeduser', $user);
                return true;
            }
        }

        return false;
    }

    public function isLogged()
    {
        $session = $this->getServiceManager()->get('Session');
        $user = $session->offsetGet('zf2base_loggeduser');
        if ( isset($user) ) {
            return true;
        }

        return false;
    }
    public function logout()
    {
        $session = $this->getServiceManager()->get('Session');
        $session->offsetUnset('zf2base_loggeduser');

        return true;
    }
}
