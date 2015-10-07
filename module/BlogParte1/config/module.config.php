<?php

 return array(
      'view_manager' => array(
         'template_path_stack' => array(
             __DIR__ . '/../view',
         ),
     ),

     'controllers' => array(
         'invokables' => array(
             'BlogParte1\Controller\Posts' => 'BlogParte1\Controller\PostsController'
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
                         'controller' => 'BlogParte1\Controller\Posts',
                         'action'     => 'index',
                     )
                 )
             )
         )
     )
 );
