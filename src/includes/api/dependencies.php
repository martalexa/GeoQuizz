<?php

$container = $app->getContainer();

$container['PartieController'] = function($c){
	return new App\Controllers\PartieController($c);
};

$container['CarteController'] = function($c){
	return new lbs\api\control\CarteController($c);
};

$container['SerieController'] = function($c){
	return new lbs\api\control\SerieController($c);
};