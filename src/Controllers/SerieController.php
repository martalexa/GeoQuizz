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
		$result = array();
		$series = Serie::select()->get();
		foreach ($series as $serie) {

			$result_temp =  $serie;
			$result_temp->city_name = $serie->city()->select("name")->first()->name;
			array_push($result,$result_temp);

		}
		return Writer::json_output($response,201,$result);

	}
	public function getSerie($request,$response,$args) {
		try {
			$serie = Serie::where("id","=",$args["id"])->firstOrFail();

			return Writer::json_output($response,201,$serie);
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
        
        public function getNumberPhotos(Request $request,Response $response,$args) {
        	try {
        		$serie=Serie::where("id","=",$args["id"])->firstOrFail();
        		$count=$serie->photos()->count();
        		return Writer::json_output($response,201,$count);
        	} catch (Exception $e) {
        		return Writer::json_output($response,500,['error' => 'Internal Server Error']);
        	}


        }
    }