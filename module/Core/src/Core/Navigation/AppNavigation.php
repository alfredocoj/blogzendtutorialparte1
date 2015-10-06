<?php
namespace Core\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

use Zend\Session\Container;
use Zend\Session\SessionManager;

class AppNavigation extends DefaultNavigationFactory
{
    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        if (null === $this->pages) {
            $sm = $serviceLocator->get('ServiceManager');

            //Pega session
            $session = $sm->get('Session');
            $user = $session->offsetGet('zf2base_loggeduser');

            //Pega o modulo atual
            $module     = $sm->get('router')->match( $sm->get('request') )->getParam('module');
            $controller = $sm->get('router')->match( $sm->get('request') )->getParam('controller');

            //Verifica permissões de recurso no modulo
            $recursos = $serviceLocator->get('Admin\Model\UsuarioModel')->getPermissoes( $module, $user->usr_id );

            //Array menu
            $navigation = array();

            foreach ($recursos as $key => $value) {
                $navigation[$value->ctr_nome]['label'] = $value->ctr_nome;
                $navigation[$value->ctr_nome]['uri']   = '/';
                $navigation[$value->ctr_nome]['icon']  = $value->ctr_icone;

                if($controller == strtolower($value->rcs_nome)){
                    $navigation[$value->ctr_nome]['activeMenu'] = 'active open';
                }

                $navigation[$value->ctr_nome]['pages'][$key] = array(
                                                                    'label'      => $value->rcs_descricao,
                                                                    'uri'        => '/'.strtolower($value->mod_nome).'/'.strtolower($value->rcs_nome).'/index',
                                                                    'controller' => strtolower($value->rcs_nome),
                                                                    'action'     => 'index',
                                                                    'active'     => (strtolower($value->rcs_nome) == $controller),
                                                                );
            }

            $mvcEvent = $serviceLocator->get('Application')->getMvcEvent();

            $routeMatch = $mvcEvent->getRouteMatch();
            $router     = $mvcEvent->getRouter();
            $pages      = $this->getPagesFromConfig($navigation);

            $this->pages = $this->injectComponents(
                $pages,
                $routeMatch,
                $router
            );

            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        }

        return $this->pages;
    }
}
