<?php

namespace App\Controllers;

// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
* 
*/
use App\Models\Serie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SerieController extends BaseController
{
	public function getSeries ($request,$response) {
		$series = Serie::select()->get();
		return $response->getBody()->write(json_encode($parties->toArray()));

	}
	public function getSerie($request,$response,$args) {
		try {
			$serie = Serie::where("id","=",$args["id"]->firstOrFail();
		} catch (ModelNotFoundException $e) {
			$notFoundHandler = $this->container->get('notFoundHandler');
			return $notFoundHandler($req,$resp);
			
		}
		
	}
	
}