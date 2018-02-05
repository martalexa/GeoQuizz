<?php
// Routes Parties
	$app->get('/parties[/]', 'PartieController:getParties')->setName('get_parties');
	$app->get('/parties/{id}[/]', 'PartieController:getPartie')->setName('get_partie');
	$app->post('/parties[/]','PartieController:createPartie')->setName('post_partie');