<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'geoquizz',
    'database'  => 'geoquizz',
    'username'  => 'admin',
    'password'  => 'admin',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => 'geo',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();