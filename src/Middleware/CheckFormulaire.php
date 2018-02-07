<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 05/02/18
 * Time: 15:21
 */
namespace App\Middleware;
use App\Controllers\Writer;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\Serie;
class CheckFormulaire {
    public  function checkFormulaire (Request $req, Response $resp, $next)
    {
        $checked = null;
        $fields=$req->getAttribute('route')->getArgument('fields');
        $formfield = $req->getParsedBody();

        foreach ($fields as $field) {
            if (!isset($formfield[$field])){
                $checked = false;
                break;
            }
            else {
                $checked = true;

            }
        }
        if ($checked==true) {
            $resp = $next($req,$resp);
            return $resp;
        }
        else {
            return Writer::json_output($resp,403,['Requête' => "Incomplète ou erronée"]);
        }
    }

}