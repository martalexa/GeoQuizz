<?php

namespace App\Controllers;

// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
* 
*/
use App\Models\Palier;
use App\Models\Serie;
use App\Models\City;
use App\Models\Time;
use App\Models\Photo;
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
			$result_temp->city = $serie->city()->select()->first();
			array_push($result,$result_temp);

		}
		return Writer::json_output($response,201,$result);

	}
	public function getSerie($request,$response,$args) {
		try {
			$serie = Serie::where("id","=",$args["id"])->firstOrFail();
			$result = $serie;
			$result->city = $serie->city()->select()->first();
			$photos = $serie->photos()->select("id","description","url","lat","lng")->get();
			$paliers = $serie->paliers()->get() ;
			$times = $serie->times()->get() ;
			foreach($photos as $key => $photo){
				$photo->url = $this->get('assets_path').'/uploads/' . $photo->url;
				$photos[$key] = $photo;
			}

			foreach($paliers as $key => $palier){
				$palier->url = $this->get('assets_path').'/uploads/' . $palier->url;
				$paliers[$key] = $palier;
			}
			foreach($times as $key => $time){
				$time->url = $this->get('assets_path').'/uploads/' . $time->url;
				$times[$key] = $time;
			}
			$result->paliers = $paliers;
			$result->times = $times;
			$result->photos = $photos;


			return Writer::json_output($response,200,$result);
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
            try{
            	$city = City::findOrFail(filter_var($tab["city"]['id'],FILTER_SANITIZE_NUMBER_INT));

            	$serie->distance = filter_var($tab["distance"],FILTER_SANITIZE_STRING);
            	$serie->city_id = $city->id;
            	
            	$serie->save();
            	$serie->city = $city;
            	// faire les valeurs par défault
            	$palier = new Palier();
            	$time = new Time();
                // configureer les objet et faire un associate
                // il faudra ensuite corriger le patch pour ne pas créer un nouvel objet
                // lorsque le coef est déjà éxistant
            	return Writer::json_output($response,201,$serie);

            }
            catch (ModelNotFoundException $ex){
            	return Writer::json_output($response, 404, array('type' => 'error', 'message' => 'ressource not found cities/'.$tab["city"]['id']));
            }
            catch (\Exception $e){
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

        /*
        * Removes a game
        */
        public function deleteSerie($request, $response, $args) {

        	try {

        		$serie = Serie::findOrFail($args['id']);

        		$serie->delete();

        		return Writer::json_output($response, 204);

        	} catch (ModelNotFoundException $e) {
        		$notFoundHandler = $this->container->get('notFoundHandler');
        		return $notFoundHandler($request,$response);
        	}

        }
        public function editSerie($request,$response,$args) {
        	try {

        		$serie = Serie::findOrFail($args['id']);
        		$tab = $request->getParsedBody();
        		$serie->city_id = filter_var($tab["city_id"],FILTER_SANITIZE_STRING);
        		$serie->distance = filter_var($tab["distance"],FILTER_SANITIZE_STRING);
        		$serie->image = filter_var($tab["image"],FILTER_SANITIZE_STRING);
        		$serie->save();

        		return Writer::json_output($response,200, $serie);

        	} catch (ModelNotFoundException $e) {
        		$notFoundHandler = $this->container->get('notFoundHandler');
        		return $notFoundHandler($request,$response);
        	}
        }
    }