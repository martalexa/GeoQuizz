<?php

namespace App\Controllers;

// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
* 
*/
use App\Models\Serie;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Controllers\Writer;
use Slim\Http\Request;
use Slim\Http\Response;

class SerieController extends BaseController
{
	public function getSeries ($request,$response) {
		$series = Serie::select()->get();
		return Writer::json_output($response,201,$series);

	}
	public function getSerie($request,$response,$args) {
		try {
			$serie = Serie::where("id","=",$args["id"])->firstOrFail();
		} catch (ModelNotFoundException $e) {
			$notFoundHandler = $this->container->get('notFoundHandler');
			return $notFoundHandler($request,$response);
			
		}
		
	}

	public function createSerie(Request $request,Response $response,$args){
	    /* La création d'une série consiste à définir la ville
            concernée et la carte associée à cette série
	    */
        $tab = $request->getParsedBody();
        $serie = new Serie();

        $serie->distance = filter_var($tab["distance"],FILTER_SANITIZE_STRING);
        $serie->city_id = filter_var($tab["city_id"],FILTER_SANITIZE_STRING);

        try{
            $serie->save();
            return Writer::json_output($response,201,$serie);

        } catch (\Exception $e){
            // revoyer erreur format json
           return Writer::json_output($response,500,['error' => 'Internal Server Error']);
        }
    }
}