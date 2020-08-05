<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Notifiable;
    public $table = "products";
    public $timestamps = false;

    protected $fillable = [
        'code', 'product_name', 'category_id', 'brand_id', 'date', 'status', 'selling_price', 'quantity' ];
}
