<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Product_Categorie extends Model
{
    use Notifiable;
    public $table = "product_categories";
    public $timestamps = false;

    protected $fillable = [
        'name',  'date', 'status' ];
}
