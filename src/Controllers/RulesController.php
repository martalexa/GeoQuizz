<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 08/02/18
 * Time: 14:32
 */

namespace App\Controllers;


use App\Models\Serie;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Palier;
use App\Models\Time;
use App\Models\City;
class RulesController extends BaseController
{

    // TODO : CORRIGER LES WRITERS POUR RENVOYE TJR LE MM MESSAGES
    public function modifyRules( Request $request,Response $response, $args){


        $idSerie = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);

        $rules = $request->getParsedBody();

        $paliers = $rules['paliers'];
        $times = $rules['times'];

        usort($times, function($r1, $r2){
            if($r1['coef'] >= $r2['coef']){
                return true;
            }
            return false;
        });
        usort($paliers, function($r1, $r2){
            if($r1['coef'] >= $r2['coef']){
                return true;
            }
            return false;
        });

        // var_dump($paliers);
        // exit();

        if(count($paliers) == 0 || count($times) == 0){
            return Writer::json_output($response, 400, ['type:' => 'error', 'message:' => 'Une règle au moins est requise par type de paramétrage']);
        }
        //CONTROLE des paliers

        $i = 1;

        foreach ($paliers as $key => $palier) {
            if((int)$palier['coef'] <= 0 || (int)$palier['points'] <= 0){
                return Writer::json_output($response, 400, ['type:' => 'error', 'message:' => 'Règles distance: Les valeurs entieres positives uniquement']);
            }

            if(isset($paliers[$i]) && (int)$palier['coef'] == $paliers[$i]['coef']){
                return Writer::json_output($response, 400, ['type:' => 'error', 'message:' => 'Règles distance: Pas de doublon de coefficient']);
            }

            $i ++;
        }

        //CONTROLE des times

        $i = 1;

        foreach ($times as $key => $time) {
            if((int)$time['coef'] <= 0 || (int)$time['nb_seconds'] <= 0){
                return Writer::json_output($response, 400, ['type:' => 'error', 'message:' => 'Règles temps: Les valeurs entieres positives uniquement']);
            }

            if(isset($times[$i]) && (int)$time['nb_seconds'] == $times[$i]['nb_seconds']){
                return Writer::json_output($response, 400, ['type:' => 'error', 'message:' => 'Règles temps: Pas de doublon de secondes']);
            }

            $i ++;
        }

        // if(!$this->controleRules($times,"nb_seconds",$response)){
        //     return Writer::json_output($response, 401, ['type:' => 'error', 'message:' => 'Bad credentials 1']);
        // }
        // if(!$this->controleRules($paliers,"points",$response)){
        //     return Writer::json_output($response, 401, ['type:' => 'error', 'message:' => 'Bad credentials 2']);
        // }


        try{
            $serie = Serie::findOrFail($idSerie);

           // var_dump($serie->city());
            //exit();
            // Supression des paliers de la base
            $tableauxBase = Palier::where('serie_id','=',$idSerie)->get();
            foreach ($tableauxBase as $palier){
                $palier->delete();
            }

            // Supression des temps de la base
            $tableauxBaseTime = Time::where('serie_id','=',$idSerie)->get();
            foreach ($tableauxBaseTime as $time){
                $time->delete();
            }

            // TABLEAU A RENVOYER
            $collectionPalier = array();
            foreach ($paliers as $palier){
                    $p = new Palier();
                    $p->serie_id = $serie->id;
                    // un coef est unique
                    $p->coef = $palier['coef'];

                    $p->points = $palier['points'];

                $p->save();
                unset($p->serie_id);
                array_push($collectionPalier, $p);
            }


            $collectionTime = array();
            foreach ($times as $time){
                $t = new Time();
                $t->serie_id = $serie->id;
                // un coef est unique
                $t->coef = $time['coef'];
                $t->nb_seconds = $time['nb_seconds'];

                $t->save();

                unset($t->serie_id);
                array_push($collectionTime, $t);
            }

            $serie->city= City::find($serie->city_id);
            $collection = $serie;
            $collection->paliers = $collectionPalier;
            $collection->times = $collectionTime;

            Writer::json_output($response, 201, $collection);

        } catch (ModelNotFoundException $e){
            return Writer::json_output($response, 404, array('type' => 'error', 'message' => 'The requested ressource was not found'));
        }
    }

    public function controleRules($tableaux,$value,$resp){

        if(isset($tableaux) && !empty($tableaux)){
            sort($tableaux);
            // Plus les coefs sont élevé plus les seconde sont basses
            $i=1;
            foreach ($tableaux as $tab){
                if (isset($tab['coef']) && !empty($tab['coef']) && isset($tab[$value]) && !empty($tab[$value])) {
                    if(isset($tableaux[$i]) && isset($tableaux[$i]['coef']) && !empty($tableaux[$i]['coef']) && isset($tableaux[$i][$value]) && !empty($tableaux[$i][$value])){

                            //les$valuede seconde suivant doivent etre plus grand
                            if($tab[$value] <= $tableaux[$i][$value]) {
                                return false;
                            }
                    } else {
                        return true;
                    }
                } else {
                    return Writer::json_output($resp, 401, ['type:' => 'error', 'message:' => 'Bad credentials 3']);
                }
                $i++;
                // Si une des valeurs est en dessous de 0
                if($tab['coef'] <= 0 || $tab[$value] < 0){
                    return Writer::json_output($resp, 401, ['type:' => 'error', 'message:' => 'Bad credentials2']);
                }
            }
        } else {
            return Writer::json_output($resp, 404, array('type' => 'error', 'message' => 'The requested ressource was not found'));
        }
    }
}