<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 07/02/18
 * Time: 10:15
 */

namespace App\Controllers;

use App\Models\Serie;
use App\Models\Palier;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Controllers\Writer;

class PalierController extends BaseController {

    public function createPalier($req, $res, $args){

        try{
            // verifie l'intégrité de l'id
            $serie = Serie::findOrFail($args['id']);
            $request_body = $req->getParsedBody();
            // Si le palier n'est pas vide
            if(isset($request_body['paliers']) && !empty($request_body['paliers'])){
                $paliers = $request_body['paliers'];
                // Pour que le tableaux soit dans l'ordre des valeurs de coeff
                sort($paliers);

                // verifier que à chaque fois que le coef augmente, le nb de points diminue
                // ensuite vérifier que les valeurs ne soit pas negative
                $i = 1;
                foreach ($paliers as $palier){
                    if (isset($palier['coef']) && !empty($palier['coef']) && isset($palier['points']) && !empty($palier['points'])){
                        // si le palier suivant existe
                        if(isset($paliers[$i]['coef']) && !empty($paliers[$i]['coef']) && isset($paliers[$i]['points']) && !empty($paliers[$i]['points'])){
                            // si le palier courant est inferieur au palier suivant
                            if($palier['coef'] < $paliers[$i]['coef']){
                                //les points du palier suivant doivent etre plus petit
                                if($palier['points'] < $paliers[$i]['points']) {
                                    return Writer::json_output($res, 401, ['type:' => 'error', 'message:' => 'Bad credentials']);
                                }
                            } else {
                               return Writer::json_output($res, 401, ['type:' => 'error', 'message:' => 'Bad credentials']);
                            }
                        }
                        $i++;
                        // Si une des valeurs est en dessous de 0
                        if($palier['coef'] < 0 || $palier['points'] < 0){
                            return Writer::json_output($res, 401, ['type:' => 'error', 'message:' => 'Bad credentials']);
                        }
                    } else {
                       return Writer::json_output($res, 401, ['type:' => 'error', 'message:' => 'Bad credentials']);
                    }
                }

                $collection = array();
                foreach ($paliers as $palier){
                    $p = new Palier();
                    $p->serie_id = $serie->id;
                    $p->coef = $palier['coef'];
                    $p->points = $palier['points'];
                    array_push($collection, $p);
                }

                foreach($collection as $palier){
                    $palier->save();
                }
                Writer::json_output($res, 201, $collection);

            } else {
                Writer::json_output($res, 401, ['type:' => 'error', 'message:' => 'Bad credentials']);
            }

        } catch (ModelNotFoundException $e) {
            Writer::json_output($res, 404, array('type' => 'error', 'message' => 'The requested ressource was not found'));
        }
    }
}