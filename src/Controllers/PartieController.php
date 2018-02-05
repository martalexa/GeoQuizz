<?php

namespace App\Controllers;

// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
* 
*/
class PartieController extends BaseController
{
	public function getParties($request, $response, $args){

		return $response->withJson(array('status' => '200 OK'));

	}
}