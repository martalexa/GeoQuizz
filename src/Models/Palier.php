<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 07/02/18
 * Time: 10:24
 */

namespace App\Models;
use \Illuminate\Database\Eloquent\Model;


/**
 * Class Palier
 * @package App\Models
 */
class Palier extends Model {

    protected $table = 'palier';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function serie(){
        return $this->belongsTo(Serie::class, 'serie_id');
    }
}