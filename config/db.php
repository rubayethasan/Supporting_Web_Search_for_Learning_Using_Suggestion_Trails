<?php

//for production
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=sswst',
    'username' => 'rubayet',
    'password' => 'Mourakkhi3$',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];

/*
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=sswst',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
];
*/