<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
    protected $table = 'tbl_payment';
    protected $fillable =
    [
        'customer_id',
        'order_id',
        'customer_name',
        'customer_address',
        'customer_contact',
        'delivery_method',
        'payment_date',
        'payment_amount',
        'payment_method',
        'payment_receipt',
        'payment_status',
        'crated_at',
        'updated_at',
        'postcode',
        'district_id',
        'state_id',
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    use HasFactory;
}
