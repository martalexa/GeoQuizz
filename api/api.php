<?php

try{

	require __DIR__.'/../vendor/autoload.php';

	$app = new \Slim\App([
		'settings' => [
			'displayErrorDetails' => true
		]
	]);

	require __DIR__.'/../src/includes/db.php';
	require __DIR__.'/../src/includes/api/dependencies.php';
	require __DIR__.'/../src/includes/api/routes.php';

	$app->run();
}
catch(RuntimeException $e){
	header('Content-type: application/json');
	header('status: 500');
	echo json_encode(array('error' => 'Internal Server Error'));
}