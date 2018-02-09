<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 07/02/18
 * Time: 15:16
 */

namespace App\Controllers;
use App\Models\Serie;
use App\Models\Time;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Controllers\Writer;
use Slim\Http\Request;
use Slim\Http\Response;

class TimeController extends BaseController
{

    public function createTime(Request $req, Response $resp, $args){

        try{
            $serie = Serie::findOrFail($args['id']);
            $request_body = $req->getParsedBody();

            if(isset($request_body['times']) && !empty($request_body['times'])){
                $times = $request_body['times'];

                $collection = array();
                foreach ($times as $time){
                    //Pas de doublon de coef
                    $testCoef = Time::where('coef','=',$time['coef'])->first();
                    // Pas de doublon de seconds
                    $testSeconds = Time::where('nb_seconds','=',$time['nb_seconds'])->first();
                    if(!$testCoef && !$testSeconds){

                        if((int)$time['coef'] <= 0 || (int)$time['nb_seconds'] <= 0){
                            return Writer::json_output($resp, 400, ['type:' => 'error', 'message:' => 'Règles temps: Les valeurs entieres positives uniquement']);
                        }

                        $t = new Time();
                        $t->serie_id = $serie->id;
                        $t->nb_seconds = $time['nb_seconds'];
                        $t->coef = $time['coef'];
                        $t->save();

                        array_push($collection,$t);
                    }
                }
            } else {
                return Writer::json_output($resp, 404, array('type' => 'error', 'message' => 'The requested ressource was not found'));
            }
            return Writer::json_output($resp, 201, $collection);
        } catch (ModelNotFoundException $e) {
            return Writer::json_output($resp, 404, array('type' => 'error', 'message' => 'The requested ressource was not found'));
        }
    }
}