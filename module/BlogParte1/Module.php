<?php
namespace BlogParte1;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface
{

    // Obtem as configurações de rotas do módulo
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        //Essa configuração diz a aplicação que as classes em __NAMESPACE__ (BlogParte1) podem ser encontradas dentro de __DIR__ . '/src/' . __NAMESPACE__ (/module/BlogParte1/src/BlogParte1).
        // Zend\Loader\StandardAutoloader usa um padrão da comunidade PHP chamado PSR-0
        // Entre outras coisas, esse padrão define o modo como o PHP mapeará os nomes das classes para o sistema de arquivo.
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
