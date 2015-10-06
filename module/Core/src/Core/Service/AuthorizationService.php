<?php
namespace Core\Service;
use Core\Util\Constantes;

class AuthorizationService extends BaseService
{
    public function grantAccess($moduleName, $controllerName, $actionName, $displayMessage = true)
    {
        $flashmessenger = $this->getServiceManager()->get('ControllerPluginManager')->get('flashmessenger');

        $enabledPermissions = $this->getServiceManager()->get('Config');
        $enabledPermissions = $enabledPermissions['access_control'];

        $preLoginOpenActions = $enabledPermissions['preloginopenactions'];
        $postLoginOpenActions = $enabledPermissions['postloginopenactions'];

        if ($this->checkPrePostAccess($preLoginOpenActions, $moduleName, $controllerName, $actionName)) {
            return true;
        }

        $auth = $this->getService('Core\Service\AuthService');
        if ( $auth->isLogged() ) {
            if ($this->checkPrePostAccess($postLoginOpenActions, $moduleName, $controllerName, $actionName)) {
                return true;
            } elseif ($this->checkPermission($moduleName, $controllerName, $actionName)) {
                return true;
            }

            if($displayMessage) {
                // so exibe a mensagem de erro se o usuario estiver logado
                $flashmessenger->setNamespace('danger')->addMessage('Acesso proibido!');
                return false;
            }
        }

        return false;
    }

    private function checkPermission($modulename, $controllerName, $actionName)
    {
        //return true;
        $session = $this->getServiceManager()->get('Session');
        $user = $session->offsetGet('zf2base_loggeduser');

        $res = $this->getService(Constantes::MODEL_PERMISSAO)->checkPermission($modulename, $controllerName, $actionName, $user->usr_id, $modulename);

        if (sizeof($res) || $controllerName == 'async' || $controllerName == 'blogparte1') {
            return true;
        }

        return false;
    }
    /**
     * Verifica se a Action acessa tem o acesso liberado via configuracao
     * Utilizada para verificar Actions liberadas tanto antes do login quanto depois do login
     *
     * @param  array   $openActions
     * @param  string  $moduleName
     * @param  string  $controllerName
     * @param  string  $actionName
     * @return boolean
     */
    private function checkPrePostAccess($openActions, $moduleName, $controllerName, $actionName)
    {
        $openModules = array_keys($openActions);
        if (in_array($moduleName, $openModules)) {
            $openControllers = array_keys($openActions[$moduleName]);
            if (in_array($controllerName, $openControllers)) {
                if (in_array($actionName, $openActions[$moduleName][$controllerName])) {
                    return true;
                }
            }
        }

        return false;
    }
}
