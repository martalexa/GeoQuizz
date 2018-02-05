<?php
/**
 * File:  Categorie.php
 * Creation Date: 09/11/2017
 * description:
 *
 * @author: canals
 */

use \Illuminate\Database\Eloquent\Model;


/**
 * Class Categorie
 * @package catawish\models
 */
class Partie extends Model {

    protected $table = 'carte';
    protected $primaryKey = 'id';
    public $timestamps = false;

}