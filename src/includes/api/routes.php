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
 * @apiSuccess {Object} serie.city Description de la ville de référence de la partie
 * @apiSuccess {Number} serie.city.id Identifiant de la ville
 * @apiSuccess {String} serie.city.name Nom de la ville
 * @apiSuccess {Number} serie.city.lat Latitude de la ville
 * @apiSuccess {Number} serie.city.lng Longitude de la ville
 * @apiSuccess {Number} serie.city.zoom_level Zoom de référence pou la carte leaflet
 * @apiSuccess {Object} serie.city.photos Photos de la série
 * @apiSuccess {Number} serie.city.photos.id Identifiant de la photo
 * @apiSuccess {String} serie.city.photos.description Description de la photo
 * @apiSuccess {String} serie.city.photos.url url de la photo
 * @apiSuccess {Number} serie.city.photos.lat Latitude du lieu de la photo
 * @apiSuccess {Number} serie.city.photos.lng Longitude du lieu de la photo
 * @apiSuccessExample {json} Success
 *	HTTP/1.1 200 OK
 *	{
 *		"player_username": "Alexandro",
 *		"id": 80,
 *		"token": "6f15d12b26e7deaa722edb44f857e185b1f6b68909caa6c0911927bce395e489",
 *		"nb_photos": 15,
 *		"state": 0,
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
 *			"photos": [{
 *				"id": 4,
 *				"description": "Le musée de l'IUT"
 *				"url": "http://web.geaoquizz.local:10085/uploads/laphoto.png",
 *				"lat": "48.6843900",
 *				"lng": "6.1849600",
 *			}]
 *		}
 *	}
 */
$app->post('/parties[/]','PartieController:createPartie')->setName('post_partie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['nb_photos','serie_id','player_username']);

/**
 * @api {put} /partie/:token Modification du score d'une partie
 * @apiGroup parties
 * @apiVersion 1.0.0
 * @apiParam {String} token Token de la partie
 * @apiHeader {String} Content-Type application/json;charset=utf-8
 * @apiParam {Number} score Score de la partie
 * @apiParamExample {json} Input
 *	PUT /parties/:token HTTP/1.1
 *	Host: api.geoquizz.local:10080 
 *	Content-Type:application/json;charset=utf-8
 * 	
 *	{
 *		"score": 30
 *	}
 * @apiSuccess {Number} id Identifiant de la partie
 * @apiSuccess {String} token Token de la partie
 * @apiSuccess {Number} nb_photos Nombre de photos choisi par la personne
 * @apiSuccess {Number} state Etat de la partie
 * @apiSuccess {String} player_username Pseudo du joueur
 * @apiSuccess {Number} score Score du joueur pour cette partie
 * @apiSuccessExample {json} Success
 *	HTTP/1.1 200 OK
 *	{
 *		"player_username": "Alexandro",
 *		"id": 80,
 *		"token": "6f15d12b26e7deaa722edb44f857e185b1f6b68909caa6c0911927bce395e489",
 *		"nb_photos": 15,
 *		"state": 0,
 *		"score": 30
 *	}
 */
$app->put('/parties/{token}[/]','PartieController:updateScore')->setName('put_score')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['score']);

/**
 * @api {put} /partie/:token/state Modification d'une partie
 * @apiGroup parties
 * @apiVersion 1.0.0
 * @apiParam {String} token Token de la partie
 * @apiHeader {String} Content-Type application/json;charset=utf-8
 * @apiParam {Number} state Etat de la partie
 * @apiParamExample {json} Input
 *	PUT /parties/:token HTTP/1.1
 *	Host: api.geoquizz.local:10080 
 *	Content-Type:application/json;charset=utf-8
 * 	
 *	{
 *		"state": 1
 *	}
 * @apiSuccess {Number} id Identifiant de la partie
 * @apiSuccess {String} token Token de la partie
 * @apiSuccess {Number} nb_photos Nombre de photos choisi par la personne
 * @apiSuccess {Number} state Etat de la partie
 * @apiSuccess {String} player_username Pseudo du joueur
 * @apiSuccess {Number} score Score du joueur pour cette partie
 * @apiSuccessExample {json} Success
 *	HTTP/1.1 200 OK
 *	{
 *		"player_username": "Alexandro",
 *		"id": 80,
 *		"token": "6f15d12b26e7deaa722edb44f857e185b1f6b68909caa6c0911927bce395e489",
 *		"nb_photos": 15,
 *		"state": 1,
 *		"score": 30
 *	}
 */
$app->patch('/parties/{token}/state','PartieController:updateState')->setName('patch_status')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['state']);

// POURQUOI CETTE ROUTE ?????
$app->patch('/parties/{token}/score','PartieController:updateScore')->setName('patch_score')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['score']);
// Routes Series
$app->get('/series[/]', 'SerieController:getSeries')->setName('get_series');

/**
 * @api {get} /series/:id/count Renvoie le nombre de photo d'une série
 * @apiGroup series
 * @apiVersion 1.0.0
 * @apiParam {Number} id id de la serie
 * @apiSuccessExample {json} Success
 * 	HTTP/1.1 200 OK
 *	12
 */
$app->get('/series/{id}/count[/]','SerieController:getNumberPhotos')->setName('get_count_photos');

/**
 * @api {get} /series/:id Avoir le détail d'une serie
 * @apiGroup series
 * @apiVersion 1.0.0
 * @apiParam {Number} id id de la serie
 * @apiSuccess {Number} id Identifiant de la serie
 * @apiSuccess {Number} distance Distance de ref pour le calcul du score
 * @apiSuccess {String} image Image de la serie
 * @apiSuccess {String} name Nom de la serie
 * @apiSuccess {Object} city Description de la ville de référence de la série
 * @apiSuccess {Number} city.id Identifiant de la ville
 * @apiSuccess {String} city.name Nom de la ville
 * @apiSuccess {Number} city.lat Latitude de la ville
 * @apiSuccess {Number} city.lng Longitude de la ville
 * @apiSuccess {Number} city.zoom_level Zoom de référence pou la carte leaflet
 * @apiSuccess {Object} paliers Palier/regle pour le calcul du score
 * @apiSuccess {Number} paliers.id Identifiant du palier
 * @apiSuccess {Number} paliers.coef Coefficient du palier
 * @apiSuccess {Number} paliers.points Points pour ce palier
 * @apiSuccess {Number} paliers.serie_id Identifiant de la serie à laquelle le palier appartient
 * @apiSuccess {Object} times Temps pour le calcul du score
 * @apiSuccess {Number} times.id Identifiant du timer
 * @apiSuccess {Number} times.coef Coefficient du palier
 * @apiSuccess {Number} times.nb_seconds temps en seconde pour aquérir le nombre de point de ce palier
 * @apiSuccess {Number} times.serie_id Identifiant de la serie à laquelle le timer appartient
 * @apiSuccess {Object} photos Photos de la série
 * @apiSuccess {Number} photos.id Identifiant de la photo
 * @apiSuccess {String} photos.description Description de la photo
 * @apiSuccess {String} photos.url url de la photo
 * @apiSuccess {Number} photos.lat Latitude du lieu de la photo
 * @apiSuccess {Number} photos.lng Longitude du lieu de la photo
 * @apiSuccessExample {json} Success
 * 	HTTP/1.1 200 OK
 *	{
 *		{
 *			"id": 17,
 *			"distance": "52",
 *			"updated_at": "2018-02-09 18:20:20",
 *			"created_at": "0000-00-00 00:00:00",
 *			"image": "e2f69e70-0dc5-11e8-96d6-0242ac130005.png",
 *			"name": "frfrf",
 *			"city": {
 *				"id": 1,
 *				"name": "Nancy",
 *				"lat": "48.6843900",
 *				"lng": "6.1849600",
 *				"zoom_level": 13
 *			},
 *			"paliers": [{
 *				"id": 37,
 *				"coef": 1,
 *				"points": 5,
 *				"serie_id": 17
 *			}],
 *			"times": [{
 *				"id": 37,
 *				"nb_seconds": 5,
 *				"coef": 4,
 *				"serie_id": 17
 *			}],
 *			"photos": [{
 *				"id": 4,
 *				"description": "Le musée de l'IUT"
 *				"url": "http://web.geaoquizz.local:10085/uploads/laphoto.png",
 *				"lat": "48.6843900",
 *				"lng": "6.1849600",
 *			}]
 *	}
 */
$app->get('/series/{id: [0-9]+}[/]','SerieController:getSerie')->setName('get_serie');



// Routes User

/**
 * @api {post} /admin/signup Création d'un compte
 * @apiGroup admin
 * @apiVersion 1.0.0
 * @apiHeader {String} Content-Type application/json;charset=utf-8
 * @apiParam {String} username username de la personne
 * @apiParam {String} password Mot de passe
 * @apiParamExample {json} Input
 *	PUT /parties/:token HTTP/1.1
 *	Host: api.geoquizz.local:10080 
 *	Content-Type:application/json;charset=utf-8
 * 	
 *	{
 *		"username": "Jean Michel",
 *		"password": "lemeilleurpassword"
 *	}
 * @apiSuccess {Number} id Identifiant du compte
 * @apiSuccess {String} username Username du compte
 * @apiSuccessExample {json} Success
 *	HTTP/1.1 200 OK
 *	{
 *		"username": "Jean Michel",
 *		"id": 10,
 *	}
 */
$app->post('/admin/signup[/]', 'UserController:createUser')->setName('post_serie')->add(\App\Middleware\CheckFormulaire::class.':checkFormulaire')->setArgument('fields',['username','password']);


/**
 * @api {post} /admin/signin Connexion
 * @apiGroup admin
 * @apiVersion 1.0.0
 * @apiHeader {String} Content-Type application/json;charset=utf-8
 * @apiHeader {String} Authorization Basic 
 * @apiParam {String} username username de la personne
 * @apiParam {String} password Mot de passe
 * @apiSuccess {String} token Token d'identification
 * @apiSuccessExample {json} Success
 *	{
 *		"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkuZ2VvcXVpenoubG9jYWxcL2F1dGgiLCJhdWQiOiJodHRwOlwvXC9hcGkuZ2VvcXVpenoubG9jYWxcLyIsImlhdCI6MTUxODIxNzcxNiwiZXhwIjoxNTE4ODIyNTE2LCJ1aWQiOjEwfQ.8KmYNSDuyu2qpURGtf08Cbf1U5xYhn7smbtnFCpp7GfyTvjSzgidFafkIP3GrMs4NOIgoMKKCr-4Q7XM5rugWg"
 *	}
 */ 
$app->post('/admin/signin[/]', 'UserController:connectUser');

$app->group('/admin', function () {

	$this->get('/series[/]', 'SerieController:getBackSeries')->setName('get_back_series');

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
