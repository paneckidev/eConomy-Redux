<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // Set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Twig renderer
        'twig' => [
            'template_path' => dirname(__DIR__) . '/resources/views',
            'cache' => false,
        ],

        // Database credentials
        'db' => [
            'driver' => 'mysql',
            'host' => 'db', // Database host
            'database' => 'economy_redux', // Database name
            'username' => 'economy', // Database user
            'password' => 'economy', // Database password
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => '',
        ],
    ],
];
