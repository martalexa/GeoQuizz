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

                $collection = array();
                foreach ($paliers as $palier){

                    $testCoef = Palier::where('coef','=',$palier['coef'])->first();
                    if(!$testCoef){

                        if((int)$palier['coef'] <= 0 || (int)$palier['points'] <= 0){
                            return Writer::json_output($res, 400, ['type:' => 'error', 'message:' => 'Règles distance: Les valeurs entieres positives uniquement']);
                        }

                        $p = new Palier();
                        $p->serie_id = $serie->id;
                        $p->coef = $palier['coef'];
                        $p->points = $palier['points'];

                        try{
                            $p->save();
                            array_push($collection, $p);
                        } catch (ModelNotFoundException $e){
                            return Writer::json_output($res,500,['error' => 'Internal Server Error']);
                        }
                    }
                }
                    return Writer::json_output($res, 201, $collection);
            } else {
                return Writer::json_output($res, 400, ['type:' => 'error', 'message:' => 'Empty value']);
            }
        } catch (ModelNotFoundException $e) {
            return Writer::json_output($res, 404, array('type' => 'error', 'message' => 'The requested ressource was not found'));
        }
    }
}