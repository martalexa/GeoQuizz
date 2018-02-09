<?php

namespace App\Controllers;

/**
* 
*/
use App\Models\Photo;
use App\Models\Serie;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Translation\Dumper\PoFileDumper;

class PhotoController extends BaseController
{

  public function base64_to_jpeg($base64_string, $output_file)
  {
    $ifp = fopen($output_file, "wb");
    fwrite($ifp, base64_decode($base64_string));
    fclose($ifp);
    return ($output_file);
}

public function check_base64_image($base64, $response)
{
        //todo : desactiver les warnings
    error_reporting(0);
    if (imagecreatefromstring(base64_decode($base64))) {
        return true;
    } else {
        return false;
    }

}

public function createPhoto($request, $response, $args)
{
    // var_dump(Serie::find(4)->photos->count());
    // exit();

    $tab = $request->getParsedBody();

    $photo_str = $tab['photo'];

    $test = $this->check_base64_image($photo_str, $response);
    if ($test) {
        $photo_str = base64_decode($photo_str);
        $picture = new Photo();
        $picture->url = Uuid::uuid1() . '.png';
        $picture->lat = filter_var($tab['lat'], FILTER_SANITIZE_SPECIAL_CHARS);
        $picture->lng = filter_var($tab['lng'], FILTER_SANITIZE_SPECIAL_CHARS);
        $picture->serie_id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);



            if (isset($tab['description']) && !empty($tab['description'])) {
                $picture->description = filter_var($tab['description'], FILTER_SANITIZE_SPECIAL_CHARS);
            } else {
                $picture->description = 'Aucune description ';
            }

            $picture->lat = filter_var($tab['lat'], FILTER_SANITIZE_SPECIAL_CHARS);
            $picture->lng = filter_var($tab['lng'], FILTER_SANITIZE_SPECIAL_CHARS);

        try {
            $serie = Serie::findOrFail($args["id"]);
            $picture->serie_id = $serie->id;
            file_put_contents($this->get('upload_path') . '/' . $picture->url, $photo_str);
            $picture->save();
            $picture->url = $this->get('assets_path') . '/uploads/' . $picture->url;
            return Writer::json_output($response, 201, $picture);

        } catch (\Exception $e) {
            $response = $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }

    } else {
        return Writer::json_output($response,400,['error' => "Bad Request"]);
    }

}
}