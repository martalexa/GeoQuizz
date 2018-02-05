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

class UserController extends BaseController
{

	public function createUser(Request $request,Response $response){

        $tab = $request->getParsedBody();
        $user = new User();

        $user->username = filter_var($tab["username"],FILTER_SANITIZE_STRING);
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
    }
}