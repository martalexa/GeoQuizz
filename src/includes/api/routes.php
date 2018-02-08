<?php

// Routes Parties
$app->get('/parties[/]', 'PartieController:getParties')->setName('get_parties');
$app->get('/parties/{id}[/]', 'PartieController:getPartie')->setName('get_partie');
$app->post('/parties[/]','PartieController:createPartie')->setName('post_partie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['nb_photos','serie_id','player_username']);
$app->put('/parties/{id}[/]','PartieController:updateScore')->setName('put_score')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['score']);
$app->patch('/parties/{token}/state','PartieController:updateState')->setName('patch_status')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['state']);
$app->patch('/parties/{token}/score','PartieController:updateScore')->setName('patch_score')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['score']);
// Routes Series
$app->get('/series[/]', 'SerieController:getSeries')->setName('get_series');
$app->get('/series/{id}/count[/]','SerieController:getNumberPhotos')->setName('get_count_photos');

$app->get('/series/{id: [0-9]+}[/]','SerieController:getSerie')->setName('get_serie');



// Routes User
$app->post('/admin/signup[/]', 'UserController:createUser')->setName('post_serie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['username','password']);
$app->post('/admin/signin[/]', 'UserController:connectUser');

$app->group('/admin', function () {

	$this->get('/series[/]', 'SerieController:getSeries')->setName('get_series');

	$this->get('/series/{id: [0-9]+}[/]','SerieController:getSerie')->setName('get_serie');

  $this->post('/series[/]', 'SerieController:createSerie')->setName('post_serie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['distance'],['name']);

	$this->delete('/series/{id: [0-9]+}[/]', 'SerieController:deleteSeries')->setName('delete_serie');

	$this->post('/series/{id: [0-9]+}/photos[/]', 'PhotoController:createPhoto')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['photo','lat','lng']);

	$this->patch('/series/{id: [0-9]+}/paliers[/]', 'PalierController:createPalier');

	$this->patch('/series/{id: [0-9]+}/edit[/]', 'SerieController:editSerie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['image','city_id','distance']);

	$this->patch('/series/{id: [0-9]+}/times[/]', 'TimeController:createTime');

	$this->put('/series/{id: [0-9]+}/rules[/]', 'RulesController:modifyRules');

	$this->get('/cities[/]','CityController:getCities')->setName('get_cities');

})->add(new \App\Middleware\CheckJwt($container));
