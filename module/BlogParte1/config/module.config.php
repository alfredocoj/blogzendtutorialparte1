<?php
namespace BlogParte1;

 return array(
      'view_manager' => array(
         'template_path_stack' => array(
             __DIR__ . '/../view',
         ),
     ),
     'service_manager' => array(
        'invokables' => array(
            /*'BlogParte1\Model\PostModel'             => 'BlogParte1\Model\PostModel',
            'BlogParte1\Model\CommentModel'          => 'BlogParte1\Model\CommentModel',*/
        )
     ),
     'controllers' => array(
         'invokables' => array(
              'BlogParte1\Controller\Posts'              => 'BlogParte1\Controller\PostsController',
              'BlogParte1\Controller\Comments'           => 'BlogParte1\Controller\CommentsController',
         )
     ),

     // This lines opens the configuration for the RouteManager
     'router' => array(
         // Open configuration for all possible routes
         'routes' => array(
             // Define a new route called "post"
             'blogparte1' => array(
                 // Define the routes type to be "Zend\Mvc\Router\Http\Literal", which is basically just a string
                 'type' => 'literal',
                 // Configure the route itself
                 'options' => array(
                     // Listen to "/blog" as uri
                     'route'    => '/blogparte1',
                     // Define default controller and action to be called when this route is matched
                     'defaults' => array(
                          '__NAMESPACE__' => 'BlogParte1\Controller',
                         'controller'     => 'Posts',
                         'action'         => 'index',
                     )
                 ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller][/:action][/:id][/:idtwo]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[0-9]+',
                                'idtwo'      => '[0-9]+',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),

                ),
             )
         )
     ),

    'doctrine' => array(
      'driver' => array(
          __NAMESPACE__ . '_driver' => array(
            'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            'cache' => 'array',
            'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
          ),
          'orm_default' => array(
            'drivers' => array(
            __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
          )
        )
    )
  )
 );
