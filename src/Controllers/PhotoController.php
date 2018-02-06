<?php

namespace App\Controllers;

/**
* 
*/
use App\Models\Photo;
use Ramsey\Uuid\Uuid;
use Spatie\Image\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Translation\Dumper\PoFileDumper;

class PhotoController extends BaseController
{
    function base64_to_jpeg( $base64_string, $output_file ) {
        $ifp = fopen( $output_file, "wb" );
        fwrite( $ifp, base64_decode( $base64_string) );
        fclose( $ifp );
        return( $output_file );
    }

    public function createPhoto($request,$response,$args){

        $tab = $request->getParsedBody();
        $photo_str = $tab['photo'];
        $photo_str = base64_decode($photo_str);

        $picture = new Photo();
        $picture->url = Uuid::uuid1().'.png';

        if(isset($tab['description']) && !empty($tab['description'])){
            $picture->description = filter_var($tab['description'],FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $picture->description = null;
        }
        $picture->lat = filter_var($tab['lat'],FILTER_SANITIZE_SPECIAL_CHARS);
        $picture->lng = filter_var($tab['lat'],FILTER_SANITIZE_SPECIAL_CHARS);
        $picture->serie_id = filter_var($tab['serie_id'],FILTER_SANITIZE_NUMBER_INT);

        try {
            $picture->url = $this->get('assets_path').'/uploads/'.$picture->url;
            $picture->save();
            file_put_contents($this->get('upload_path').'/'.$picture->url, $photo_str);
            return Writer::json_output($response,201,$picture);

        } catch (Exception $e) {
            $response = $response->withHeader('Content-Type','application/json')->withStatus(500);
            $response->getBody()->write(json_encode(['type' => 'error', 'error' => 500, 'message' => $e->getMessage()]));
        }





    }
}