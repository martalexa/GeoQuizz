<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 07/02/18
 * Time: 15:23
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $table = "temps";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function serie(){
        return $this->belongsTo(Serie::class, "serie_id");
    }
}