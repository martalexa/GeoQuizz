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

class PalierController extends BaseController{

    public function createPalier($req, $res, $args){
        try{
            $serie = Serie::findOrFail($args['id']);
            $request_body = $req->getParsedBody();

            $paliers = $request_body['paliers'];

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

        }catch(ModelNotFoundException $e) {
            Writer::json_output($res, 404, array('type' => 'error', 'message' => 'The requested ressource was not found'));
        }


    }

}