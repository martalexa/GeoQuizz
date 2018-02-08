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
            $times = $request_body['times'];
            sort($times);

            if(isset($request_body['times']) && !empty($request_body['times'])){
                $times = $request_body['times'];
                sort($times);
                // Plus les coefs sont élevé plus les seconde sont basses
                $i=1;

                foreach ($times as $time){
                    if (isset($time['coef']) && !empty($time['coef']) && isset($time['nb_seconds']) && !empty($time['nb_seconds'])) {
                        if(isset($times[$i]['coef']) && !empty($times[$i]['coef']) && isset($times[$i]['nb_seconds']) && !empty($times[$i]['nb_seconds'])){
                            // si le coef courant est inferieur au coef suivant
                            if($time['coef'] < $times[$i]['coef']){
                                //les nb_seconds de seconde suivant doivent etre plus grand
                                if($time['nb_seconds'] <= $times[$i]['nb_seconds']) {
                                    return Writer::json_output($resp, 401, ['type:' => 'error', 'message:' => 'Bad credentials 1']);
                                }
                            } else {
                                return Writer::json_output($resp, 401, ['type:' => 'error', 'message:' => 'Bad credentials 2']);
                            }
                        }
                    } else {
                        return Writer::json_output($resp, 401, ['type:' => 'error', 'message:' => 'Bad credentials 3']);
                    }
                    $i++;
                    // Si une des valeurs est en dessous de 0
                    if($time['coef'] <= 0 || $time['nb_seconds'] < 0){
                        return Writer::json_output($resp, 401, ['type:' => 'error', 'message:' => 'Bad credentials2']);
                    }
                }
            } else {
                return Writer::json_output($resp, 404, array('type' => 'error', 'message' => 'The requested ressource was not found'));
            }


            $collection = array();
           foreach ($times as $time){
               $testCoef = Time::where('coef','=',$time['coef'])->first();
               if(!$testCoef){
                   $t = new Time();
                   $t->serie_id = $serie->id;
                   $t->nb_seconds = $time['nb_seconds'];
                   $t->coef = $time['coef'];

                   $t->save();
                   array_push($collection,$t);
               }
            }
            Writer::json_output($resp, 201, $collection);
        } catch (ModelNotFoundException $e) {
            Writer::json_output($resp, 404, array('type' => 'error', 'message' => 'The requested ressource was not found'));
        }
    }
}