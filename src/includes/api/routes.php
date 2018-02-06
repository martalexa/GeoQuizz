<?php

	$app->get('/parties[/]', 'PartieController:getParties')->setName('get_parties');
	$app->post('/serie[/]', 'SerieController:createSerie')->setName('post_serie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['distance','city_id']);
    $app->post('/photo[/]', 'PhotoController:createPhoto')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['photo','lat','lng','serie_id']);