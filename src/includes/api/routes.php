<?php

// Routes Parties

/**
 * @api {get} /parties Lites des parties
 * @apiGroup parties
 * @apiVersion 1.0.0
 * @apiSuccess {Number} id Identifiant de la partie
 * @apiSuccess {String} token Token de la partie
 * @apiSuccess {Number} nb_photos Nombre de photos choisi par la personne
 * @apiSuccess {Number} state Etat de la partie
 * @apiSuccess {String} player_username Pseudo du joueur
 * @apiSuccess {Number} score Score du joueur pour cette partie
 * @apiSuccessExample {json} Success
 * 	HTTP/1.1 200 OK
 *	{
 *		"id": 7,
 *		"token": "6f15d12b26e7deaa722edb44f857e185b1f6b68909caa6c0911927bce395e489",
 *		"nb_photos": 5,
 *		"state": 0,
 *		"player_username": "Michel",
 *		"score": 5
 *	}
 */
$app->get('/parties[/]', 'PartieController:getParties')->setName('get_parties');

/**
 * @api {get} /parties/:id Avoir une partie
 * @apiGroup parties
 * @apiVersion 1.0.0
 * @apiParam {id} id Identifiant de la partie
 * @apiSuccess {Number} id Identifiant de la partie
 * @apiSuccess {String} token Token de la partie
 * @apiSuccess {Number} nb_photos Nombre de photos choisi par la personne
 * @apiSuccess {Number} state Etat de la partie
 * @apiSuccess {String} player_username Pseudo du joueur
 * @apiSuccess {Number} score Score du joueur pour cette partie
 * @apiSuccess {Object} serie Série choisi
 * @apiSuccess {Number} serie.id Identifiant de la serie
 * @apiSuccess {Number} serie.distance Distance de référence
 * @apiSuccess {String} serie.image Image de la série
 * @apiSuccess {String} serie.name Nom de la série
 * @apiSuccess {Object} serie.city Description de la ville de référence de la série
 * @apiSuccess {Number} serie.city.id Identifiant de la ville
 * @apiSuccess {String} serie.city.name Nom de la ville
 * @apiSuccess {Number} serie.city.lat Latitude de la ville
 * @apiSuccess {Number} serie.city.lng Longitude de la ville
 * @apiSuccess {Number} serie.city.zoom_level Zoom de référence pou la carte leaflet
 * @apiSuccessExample {json} Success
 * 	HTTP/1.1 200 OK
 *	{
 *		"id": 7,
 *		"token": "6f15d12b26e7deaa722edb44f857e185b1f6b68909caa6c0911927bce395e489",
 *		"nb_photos": 15,
 *		"state": 0,
 *		"player_username": "Michel",
 *		"score": 5,
 *		"serie": {
 *			"id": 2,
 *			"distance": "100",
 *			"updated_at": "2018-02-05 14:11:47",
 *			"created_at": "2018-02-05 14:11:47",
 *			"image": "",
 *			"name": "",
 *			"city": {
 *				"id": 1,
 *				"name": "Nancy",
 *				"lat": "48.6843900",
 *				"lng": "6.1849600",
 *				"zoom_level": 13
 *			}
 *		}
 *	}
 */
$app->get('/parties/{id}[/]', 'PartieController:getPartie')->setName('get_partie');

/**
 * @api {post} /partie Création d'une partie (jouer)
 * @apiGroup parties
 * @apiVersion 1.0.0
 * @apiHeader {String} Content-Type application/json;charset=utf-8
 * @apiParam {String} player_username Pseudo du joueur
 * @apiParam {Number} nb_photos Nombre de photo choisi
 * @apiParam {Number} serie_id Identifiant de la série
 * @apiParamExample {json} Input
 *	POST /parties HTTP/1.1
 *	Host: api.geoquizz.local:10080 
 *	Content-Type:application/json;charset=utf-8
 * 	
 *	{
 *		"player_username": "Alexandro",
 *		"nb_photos": 15,
 *		"serie_id": 7
 *	}
 * @apiSuccess {Number} id Identifiant de la partie
 * @apiSuccess {String} token Token de la partie
 * @apiSuccess {Number} nb_photos Nombre de photos choisi par la personne
 * @apiSuccess {Number} state Etat de la partie
 * @apiSuccess {String} player_username Pseudo du joueur
 * @apiSuccess {Number} score Score du joueur pour cette partie
 * @apiSuccess {Object} serie Série choisi
 * @apiSuccess {Number} serie.id Identifiant de la serie
 * @apiSuccess {Number} serie.distance Distance de référence
 * @apiSuccess {String} serie.image Image de la série
 * @apiSuccess {String} serie.name Nom de la série
 * @apiSuccess {Object} serie.city Description de la ville de référence de la série
 * @apiSuccess {Number} serie.city.id Identifiant de la ville
 * @apiSuccess {String} serie.city.name Nom de la ville
 * @apiSuccess {Number} serie.city.lat Latitude de la ville
 * @apiSuccess {Number} serie.city.lng Longitude de la ville
 * @apiSuccess {Number} serie.city.zoom_level Zoom de référence pou la carte leaflet
 * @apiSuccess {Object} serie.city.photos Photos de la série
 * @apiSuccess {String} serie.city.photos.url url des photos
 * @apiSuccessExample {json} Success
 *	HTTP/1.1 200 OK
 *	{
 *		"player_username": "Alexandro",
 *		"id": 80,
 *		"token": "6f15d12b26e7deaa722edb44f857e185b1f6b68909caa6c0911927bce395e489",
 *		"nb_photos": 15,
 *		"state": 0,
 *		"player_username": "Michel",
 *		"score": 5,
 *		"serie": {
 *			"id": 2,
 *			"distance": "100",
 *			"updated_at": "2018-02-05 14:11:47",
 *			"created_at": "2018-02-05 14:11:47",
 *			"image": "",
 *			"name": "",
 *			"city": {
 *				"id": 1,
 *				"name": "Nancy",
 *				"lat": "48.6843900",
 *				"lng": "6.1849600",
 *				"zoom_level": 13
 *			},
 *			"photos": {
 *				"url": "http://web.geaoquizz.local:10085/laphoto.png"
 *			}
 *		}
 *	}
 */
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
