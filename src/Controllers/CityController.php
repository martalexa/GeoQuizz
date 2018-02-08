<?php

namespace App\Controllers;

// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
* 
*/
use App\Models\City;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Controllers\Writer;
use Slim\Http\Request;
use Slim\Http\Response;

class CityController extends BaseController
{
	public function getCities ($request, $response, $args) {
		$cities = City::get();
		return Writer::json_output($response,200,$cities);
	}
}