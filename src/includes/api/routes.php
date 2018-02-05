<?php

	$app->get('/parties[/]', 'PartieController:getParties')->setName('get_parties');
	$app->post('/serie[/]', 'SerieController:createSerie')->setName('post_serie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['distance','city_id']);
