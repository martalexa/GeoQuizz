<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 05/02/18
 * Time: 11:51
 */
namespace App\Models;
use \Illuminate\Database\Eloquent\Model;
class Photo extends Model
{
    protected $table = 'photo';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function partie(){
        return $this->belongsTo(Partie::class, 'partie_id');
    }

    public function serie(){
        return $this->belongsTo(Serie::class, 'serie_id');
    }
}