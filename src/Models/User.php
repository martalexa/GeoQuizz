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
 * @package Api\models
 */
class User extends Model {

    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;
}