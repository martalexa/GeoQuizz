<?php

$container = $app->getContainer();

$container['PartieController'] = function($c){
	return new App\Controllers\PartieController($c);
};

$container['SerieController'] = function($c){
	return new App\Controllers\SerieController($c);
};


$container['PhotoController'] = function ($c) {
    return new App\Controllers\PhotoController($c);
};
$container['CityController'] = function ($c) {
    return new App\Controllers\CityController($c);
};

$container['UserController'] = function($c){
	return new App\Controllers\UserController($c);
};

$container['PalierController'] = function($c){
    return new App\Controllers\PalierController($c);
};

$container['TimeController'] = function($c){
    return new \App\Controllers\TimeController($c);
};

$container['RulesController'] = function ($c){
    return new  App\Controllers\RulesController($c);
};
//Photo upload path

$container['upload_path'] = __DIR__.'/../../../web/uploads';


//web assets domain

$container['assets_path'] = 'http://web.geoquizz.local:10085';