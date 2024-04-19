<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
    protected $table = 'tbl_product';
    protected $fillable =
        [
        'product_name',
        'product_details',
        'cost_price',
        'unit_price',
        'total_stock',
        'category_id',
        'uom_id',
    ];

    use HasFactory;

}
