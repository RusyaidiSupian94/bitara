<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class State extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
    protected $table = 'tbl_state';

}