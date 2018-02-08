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
 * Class User
 * @package App\Models
 */
class User extends Model {

    /**
     * @var string
     */
    protected $table = 'user';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var bool
     */
    public $timestamps = false;
}