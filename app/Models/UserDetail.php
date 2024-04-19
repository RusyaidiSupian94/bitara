<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
    protected $table = 'tbl_user_detail';
    protected $fillable =
    [
        'user_id',
        'fname',
        'lname',
        'address_1',
        'address_2',
        'postcode',
        'state_id',
        'contact_no',
        'email_address',
    ];
}
