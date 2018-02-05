<?php

	$app->get('/parties[/]', 'PartieController:getParties')->setName('get_parties');