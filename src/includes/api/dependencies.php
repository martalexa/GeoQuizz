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

$container['UserController'] = function($c){
	return new App\Controllers\UserController($c);
};

$container['PalierController'] = function($c){
    return new App\Controllers\PalierController($c);
};

//Photo upload path

$container['upload_path'] = __DIR__.'/../../../web/uploads';


//web assets domain

$container['assets_path'] = 'http://web.geoquizz.local:10085';