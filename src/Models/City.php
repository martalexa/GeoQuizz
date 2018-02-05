<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 05/02/18
 * Time: 11:57
 */
use \Illuminate\Database\Eloquent\Model;
class City
{
    protected $table = 'city';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function series(){
        return $this->hasMany(Serie::class,'city_id');
    }

}