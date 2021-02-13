<?php

return [
    'propel' => [
        'database' => [
            'connections' => [
                'bookstore' => [
                    'adapter'    => 'mysql',
                    'classname'  => 'Propel\Runtime\Connection\ConnectionWrapper',
                    'dsn'        => 'mysql:host=localhost;dbname=rocpass',
                    'user'       => 'friedicecream',
                    'password'   => 'Campbell3%emilia',
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'bookstore',
            'connections' => ['bookstore']
        ],
        'generator' => [
            'defaultConnection' => 'bookstore',
            'connections' => ['bookstore']
        ]
    ]
];

?>