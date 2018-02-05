<?php
/**
 * File:  Categorie.php
 * Creation Date: 09/11/2017
 * description:
 *
 * @author: canals
 */
namespace App\Models;
use \Illuminate\Database\Eloquent\Model;


/**
 * Class Categorie
 * @package catawish\models
 */
class Partie extends Model {

    protected $table = 'partie';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function serie(){
        return $this->belongsTo(Serie::class, 'serie_id');
    }

    public function photos(){
        return $this->hasMany(Photo::class, 'partie_id');
    }
}