<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
    protected $table = 'tbl_order';
    protected $fillable =
        [
        'customer_id',
        'order_status',
        'date',
        'total_amount',
        'fullfillment_status',
        'created_at',
        'updated_status_by',
        'updated_status_at',
    ];

     public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
     public function customer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    use HasFactory;

}
