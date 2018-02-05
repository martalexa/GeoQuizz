<?php

namespace App\Controllers;

// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
* 
*/
use App\Models\Partie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PartieController extends BaseController
{
	public function getParties($request, $response, $args){
		$parties = Partie::select()->get();
		$response = $response->withHeader('Content-Type', 'application/json')->withStatus(200);
		return $response->getBody()->write(json_encode($parties->toArray()));
	}

	public function getPartie($request,$response,$args) {
		try {
			$partie = Partie::where("id","=",$args['id'])->firstOrFail();
			$response = $response->withHeader('Content-Type', 'application/json')->withStatus(200);
			return $response->getBody()->write(json_encode($partie->toArray()));
			
		} catch (ModelNotFoundException $exception){

			$notFoundHandler = $this->container->get('notFoundHandler');
			return $notFoundHandler($req,$resp);
		}

	}

	public function createPartie($request,$response) {
		$tab = $request->getParsedBody();
		$partie = new Partie();
		$partie->player_username = filter_var($tab["player_username"],FILTER_SANITIZE_STRING);
		$partie->score = 0;
		$partie->nb_photos=filter_var($tab["nb_photos"],FILTER_SANITIZE_NUMBER_FLOAT);
		$partie->serie_id = filter_var($tab["serie_id"],FILTER_SANITIZE_NUMBER_FLOAT);
		      $partie->token = bin2hex(openssl_random_pseudo_bytes(32));
		$partie->state =0;   

		try{
			$partie->save();
			$response = $response->withHeader('Content-Type', 'application/json')->withStatus(201);
			$response->getBody()->write(json_encode($partie->toArray()));
			return $response;

		} catch (\Exception $e){
			$response = $response->withHeader('Content-Type','application/json')->withStatus(500);
			$response->getBody()->write(json_encode(['type' => 'error', 'error' => 500, 'message' => $e->getMessage()]));

		}
	}
	
}