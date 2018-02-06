<?php

namespace App\Controllers;

// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
* 
*/
use App\Controllers\Writer;
use App\Models\Partie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PartieController extends BaseController
{

	public function getParties($request, $response, $args){
		$parties = Partie::select()->get();
		return Writer::json_output($response,200,$parties);
	}

	public function getPartie($request,$response,$args) {
		try {
			$result = array();
			$partie = Partie::where("id","=",$args['id'])->firstOrFail();
			array_push($result,$partie);
				
			return Writer::json_output($response,200,$partie);
			
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
					return Writer::json_output($response,200,$partie);
	

		} catch (\Exception $e){
			$response = $response->withHeader('Content-Type','application/json')->withStatus(500);
			$response->getBody()->write(json_encode(['type' => 'error', 'error' => 500, 'message' => $e->getMessage()]));

		}
	}
	public function updateScore($request,$response,$args) {
		$tab = $request->getParsedBody();
		try {
			$partie = Partie::where("id","=",$args["id"])->firstOrFail();
		} catch (ModelNotFoundException $e) {
						$notFoundHandler = $this->container->get('notFoundHandler');
			return $notFoundHandler($req,$resp);
		}
		try {
			$partie->score =filter_var($tab["score"],FILTER_SANITIZE_NUMBER_FLOAT);
			$partie->save();
				return Writer::json_output($response,200,$partie);
		} catch (Exception $e) {
			$response = $response->withHeader('Content-Type','application/json')->withStatus(500);
			$response->getBody()->write(json_encode(['type' => 'error', 'error' => 500, 'message' => $e->getMessage()]));
		}
		
	}
}