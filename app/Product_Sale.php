<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
 

class Product_Sale extends Model
{
    use Notifiable;
    public $table = "product_sales";
    public $timestamps = false;

    protected $fillable = [
        'bill_id', 'product_id', 'cost', 'selling_price', 'discount', 'qty', 'discounted_amount', 'total_value' ];
}
