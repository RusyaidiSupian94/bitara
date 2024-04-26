<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
    protected $table = 'tbl_cart';
    protected $fillable =
        [
        'product_id',
        'product_qty',
        'product_uom',
        'sub_total',
    ];

    use HasFactory;

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    public function weight()
    {
        return $this->hasOne(UOM::class, 'id', 'product_uom');
    }
}
