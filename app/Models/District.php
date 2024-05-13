<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class District extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
    protected $table = 'tbl_district';

}