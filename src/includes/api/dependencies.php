<?php

$container = $app->getContainer();

$container['PartieController'] = function($c){
	return new App\Controllers\PartieController($c);
};

$container['SerieController'] = function($c){
	return new App\Controllers\SerieController($c);
};

$container['PhotoController'] = function ($c){
    return new App\Controllers\PhotoController($c);
};