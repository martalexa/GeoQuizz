<?php

// Routes Parties
	$app->get('/parties[/]', 'PartieController:getParties')->setName('get_parties');
	$app->get('/parties/{id}[/]', 'PartieController:getPartie')->setName('get_partie');
	$app->post('/parties[/]','PartieController:createPartie')->setName('post_partie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['nb_photos','serie_id','player_username']);
	$app->put('/parties/{id}[/]','PartieController:updateScore')->setName('put_score')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['score']);
// Routes Series
    $app->get('/series[/]', 'SerieController:getSeries')->setName('get_series');
	$app->get('/serie/{id}/count[/]','SerieController:getNumberPhotos')->setName('get_count_photos');

// Routes City
    $app->get('/cities[/]','CityController:getCities')->setName('get_cities');

// Routes User
	$app->post('/admin/signup[/]', 'UserController:createUser')->setName('post_serie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['username','password']);
    $app->post('/admin/signin[/]', 'UserController:connectUser');

    $app->group('/admin', function () {
        $this->post('/series[/]', 'SerieController:createSerie')->setName('post_serie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['distance','city_id']);
        $this->post('/series/{id: [0-9]+}/photos[/]', 'PhotoController:createPhoto')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['photo','lat','lng']);
        $this->patch('/series/{id: [0-9]+}/paliers[/]', 'PalierController:createPalier');
    })->add(new \App\Middleware\CheckJwt($container));