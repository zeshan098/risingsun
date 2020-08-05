<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Product_Location extends Model
{
    use Notifiable;
    public $table = "product_locations";
    public $timestamps = false;

    protected $fillable = [
        'product_id',  'location', 'quantity' ];
}
