<?php

// Routes Parties
	$app->get('/parties[/]', 'PartieController:getParties')->setName('get_parties');
	$app->get('/parties/{id}[/]', 'PartieController:getPartie')->setName('get_partie');
	$app->post('/parties[/]','PartieController:createPartie')->setName('post_partie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['nb_photos','serie_id','player_username']);
	$app->put('/parties/{id}[/]','PartieController:updateScore')->setName('put_score')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['score']);
// Routes Series
	$app->post('/serie[/]', 'SerieController:createSerie')->setName('post_serie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['distance','city_id']);

    $app->post('/photo[/]', 'PhotoController:createPhoto')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['photo','lat','lng','serie_id']);

	$app->get('/series[/]', 'SerieController:getSeries')->setName('get_series');

// Routes User
	$app->post('/user[/]', 'UserController:createUser')->setName('post_serie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['username','password']);
    $app->get('/user[/]', 'UserController:connectUser');