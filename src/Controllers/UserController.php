<?php

namespace App\Controllers;

// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
* 
*/
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Controllers\Writer;
use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;

class UserController extends BaseController
{

	public function createUser(Request $request,Response $response){

        $tab = $request->getParsedBody();
        $user = new User();
        // todo: verifier si l'user existe deja
        $user->username = filter_var($tab["username"],FILTER_SANITIZE_STRING);

        // verification auprès de la base
        $test = User::select('id')->where('username','=',$user->username)->first();

        if(empty($test)){
            $pass = filter_var($tab["password"],FILTER_SANITIZE_STRING);
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $user->password = $pass;

            try{
                $user->save();
                return Writer::json_output($response,201,$user);

            } catch (\Exception $e){
                // revoyer erreur format json
                return Writer::json_output($response,500,['error' => 'Internal Server Error']);
            }
        } else {
            return Writer::json_output($response,401,['error' => "Bad credentials"]);
        }
    }

    public function connectUser(Request $req,Response $resp){

        // EN UTILISANT RESTED : ENVOYE
        // AUTHO : BASIC
        // BASIC AUTH : ID CARTE - PASS

        // SI HTTP AUTHORIZATION EST MANQUANT
        if(!$req->hasHeader("Authorization")){

            // JE RENVOIE LE TYPE D'AUTH NECESSAIRE
            $resp = $resp->withHeader('WWW-Authenticate', 'Basic realm="api.lbs.local"');
            return Writer::json_output($resp, 401, ['type' => 'error', 'error' => 401, 'message' => 'no authorization header present']);
        }


        // SINON L'EN-TETE EST PRESENT
        $auth = base64_decode(explode( " ", $req->getHeader('Authorization')[0])[1]);
        //SEPARATION DE L'ID DE LA CARTE ET DU MDP
        list($username, $pass) = explode(':', $auth);

        // ALORS JE TEST AVEC LA BDD
        try {
            $user = User::where('username','=',$username)->firstOrFail();

            // SI MAUVAIS MDP
            if (!password_verify($pass,$user->password)){
                throw new \Exception("Bad credentials");
            }

        } catch (ModelNotFoundException $e){

            $resp = $resp->withHeader('WWW-Authenticate', 'Basic realm="api.geoquizz.local"');
            return Writer::json_output($resp,401,['error' => "Une authentification est nécessaire pour accéder à la ressource"]);

        } catch (\Exception $e){

            $resp = $resp->withHeader('WWW-Authenticate', 'Basic realm="api.geoquizz.local"');
            return Writer::json_output($resp,401,['error' => $e->getMessage()]);
        }

        // SI ON ARRIVE ICI C'EST QUE TOUT EST BON : ON CREER LE TOKEN JWT
        $mysecret = 'je suis un secret $µ°';
        $token = JWT::encode([
            'iss' => "http://api.geoquizz.local/auth",
            'aud' => "http://api.geoquizz.local/",
            'iat' => time(),
            'exp' => time()+604800,// une semaine
            'uid' => $user->id ],
            $mysecret, 'HS512');

        return Writer::json_output($resp,201,["token" => $token]);
    }
}