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
        'order_type',
        'date',
        'total_amount',
        'fullfillment_status',
        'created_at',
        'updated_at',
        'preparing_at',
        'preparing_by',
        'ready_at',
        'ready_by',
        'delivering_at',
        'delivering_by',
        'completed_at',
        'completed_by',
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'id', 'order_id');
    }

    use HasFactory;

}
