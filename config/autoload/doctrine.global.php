<?php
/**
 * Created by CursoZF2.
 * Date: 09/11/15
 */

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => '',
                    'password' => '',
                    'dbname'   => '',
                    'driver' => 'pdo_mysql',
                )
            )
        ),
    ),
);