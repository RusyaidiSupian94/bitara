<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Postcode extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
    protected $table = 'tbl_postcode';

    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }
    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }
}