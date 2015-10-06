<?php
return array(
    'service_manager' => array(
        'factories'   => array(
            'Session' => function ($serviceManager) {
                return new Zend\Session\Container('zf2base_loggeduser');
            },
            'navigation'  => 'Core\Navigation\AppNavigationFactory',
            'breadcrumbs' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
        'invokables' => array(
            'Core\Service\AuthorizationService' => 'Core\Service\AuthorizationService',
            'Core\Service\AuthService'          => 'Core\Service\AuthService',
            'Core\Service\ReportService'        => 'Core\Service\ReportService',
        )
    ),
    'view_helpers' => array(
        'factories' => array(
            'flashMessage' => function ($serviceManager) {
                $flashmessenger = $serviceManager->getServiceLocator()->get('ControllerPluginManager')->get('flashmessenger');
                $message = new Core\View\Helper\FlashMessages();
                $message->setFlashMessenger( $flashmessenger );

                return $message;
            }
        ),
        'invokables'=> array(
            'session'         => 'Core\View\Helper\Session',
            'menuBar'         => 'Core\View\Helper\MenuBar',
            'elementToRow'    => 'Core\View\Helper\ElementToRow',
            'elementToSubmit' => 'Core\View\Helper\ElementToSubmit',
            'ElementToInLine' => 'Core\View\Helper\ElementToInLine',
            'checkBoxToRow'   => 'Core\View\Helper\CheckBoxToRow',
        ),
    ),
);
