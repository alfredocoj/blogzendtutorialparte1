<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'HelloWorld\Controller\Index' => 'HelloWorld\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'helloworld' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/helloworld',
                    'defaults' => array(
                        '__NAMESPACE__' => 'HelloWorld\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                        'module'        => 'HelloWorld'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'child_routes' => array( //permite mandar dados pela url
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),

                ),
            ),
        ),
    ),
    'view_manager' => array( //the module can have a specific layout
        'template_path_stack' => array(
            'HelloWorld' => __DIR__ . '/../view',
        ),
    ),
);
