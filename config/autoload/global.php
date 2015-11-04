<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => '10.0.0.15',
                    'port'     => '3306',
                    'user'     => '',
                    'password' => '',
                    'dbname'   => '',
                    'driver' => 'pdo_mysql',
                )
            )
        ),
    ),
    'db' => array(
       'driver'         => 'Pdo',
       'dsn'            => 'mysql:dbname=pde;host=10.0.0.15',
       'driver_options' => array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
        'username' => 'bsc',
        'password' => 'bsc.12qwaszx',
    ),
    'acl' => array(
        'roles' => array(
            'visitante'   => null,
            'redator'  => 'visitante',
            'admin' => 'redator'
        ),
        'resources' => array(
            'Application\Controller\Index.index',
            'Admin\Controller\Auth.index',
            'Admin\Controller\Auth.login',
            'Admin\Controller\Auth.logout',
            'Admin\Controller\Posts.save',
            'Admin\Controller\Posts.delete',
            'Admin\Controller\Posts.index',
            'Admin\Controller\Comments.index',
            'Admin\Controller\Comments.create',
            'Admin\Controller\Comments.update',
            'Admin\Controller\Comments.delete',
            'BlogParte1\Controller\Posts.index',
            'BlogParte1\Controller\Posts.create',
            'BlogParte1\Controller\Posts.update',
            'BlogParte1\Controller\Posts.delete',
            'BlogParte1\Controller\Comments.index',
            'BlogParte1\Controller\Comments.create',
            'BlogParte1\Controller\Comments.update',
            'BlogParte1\Controller\Comments.delete',
            'HelloWorld\Controller\Index.index',
        ),
        'privilege' => array(
            'visitante' => array(
                'allow' => array(
                    'Application\Controller\Index.index',
                    'Admin\Controller\Auth.index',
                    'Admin\Controller\Auth.login',
                    'Admin\Controller\Auth.logout',
                    'BlogParte1\Controller\Posts.index',
                    'BlogParte1\Controller\Posts.create',
                    'BlogParte1\Controller\Posts.update',
                    'BlogParte1\Controller\Posts.delete',
                    'BlogParte1\Controller\Comments.index',
                    'BlogParte1\Controller\Comments.create',
                    'BlogParte1\Controller\Comments.update',
                    'BlogParte1\Controller\Comments.delete',
                    'HelloWorld\Controller\Index.index',
                )
            ),
            'redator' => array(
                'allow' => array(
                    'Admin\Controller\Posts.save',
                )
            ),
            'admin' => array(
                'allow' => array(
                    'Admin\Controller\Posts.save',
                    'Admin\Controller\Posts.delete',
                    'Admin\Controller\Posts.index',
                    'Admin\Controller\Posts.delete',
                    'Admin\Controller\Comments.index',
                    'Admin\Controller\Comments.create',
                    'Admin\Controller\Comments.update',
                    'Admin\Controller\Comments.delete',
                )
            ),
        )
    )
);
