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
use Ramsey\Uuid\Uuid;

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

	public function createSerie(Request $request,Response $response){
	    /* La création d'une série consiste à définir la ville
            concernée et la carte associée à cette série
	    */
            $tab = $request->getParsedBody();
            $serie = new Serie();

            $serie->distance = filter_var($tab["distance"],FILTER_SANITIZE_STRING);
            if(isset($tab['image']) && !empty($tab['image'])){
                $photo_str = $tab['image'];
                $testPhoto = new PhotoController($this->container);
                $test = $testPhoto->check_base64_image($photo_str,$response);
                if ($test) {
                    $serie->image = Uuid::uuid1() . '.png';
                    $photo_str = base64_decode($photo_str);
                    file_put_contents($this->get('upload_path') . '/' . $serie->image, $photo_str);
                } else {
                    return Writer::json_output($response,400,['error' => "Bad Request"]);
                }
            }

            $paliers = array();
            try{
                $city = City::findOrFail(filter_var($tab["city"]['id'],FILTER_SANITIZE_NUMBER_INT));
                $serie->city_id = filter_var($tab["city"]['id'],FILTER_SANITIZE_NUMBER_INT);
                $serie->save();
                $serie->city = $city;

                if(isset($tab['image']) && !empty($tab['image'])) {
                    $serie->image = $this->get('assets_path') . '/uploads/' . $serie->image;
                }

                $result = $serie;
            	// faire les valeurs par défault
                // 3 palier par default
                $tableaux = [];
                for ($i=1; $i<4; $i++) {
                    $palier = new Palier();
                    $palier->coef = $i;
                    switch ($i) {
                        case 1:
                            $palier->points = 5;
                            break;
                        case 2:
                            $palier->points = 3;
                            break;
                        case 3:
                            $palier->points = 1;
                            break;
                    }
                    $palier->serie()->associate($serie);
                    $palier->save();
                    $tableauxFor = array('id' => $palier->id, 'coef' => $palier->coef, 'points' => $palier->points);
                    array_push($tableaux,$tableauxFor);
                }

                array_push($paliers,['paliers' => $tableaux]);

                $tableau2 = [];
                // 3 temps par defaults
                for ($i = 4 ; $i >= 1;$i = $i / 2) {
                    $time = new Time();
                    $time->coef = $i;
                    switch ($i) {
                        case 4:
                            $time->nb_seconds = 5;
                            break;
                        case 2:
                            $time->nb_seconds = 10;
                            break;
                        case 1:
                            $time->nb_seconds = 20;
                            break;
                    }
                    $time->serie()->associate($serie);
                    $time->save();
                    $tableauxFor2 = array('id' => $time->id, 'coef' => $time->coef, 'seconds' => $time->nb_seconds);
                    array_push($tableau2,$tableauxFor2);
                }
                array_push($paliers,["Times" => $tableau2]);
                $result->rules = $paliers;
            	return Writer::json_output($response,201,["serie" => $result]);

            } catch (ModelNotFoundException $ex){
            	return Writer::json_output($response, 404, array('type' => 'error', 'message' => 'ressource not found cities/'.$tab["city"]['id']));
            } catch (\Exception $e){
            // revoyer erreur format json
            	return Writer::json_output($response,500,['error' => $e->getMessage()]);
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