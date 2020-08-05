<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Notifiable;
    public $table = "customers";
    public $timestamps = false;

    protected $fillable = [
        'name', 'phone_no', 'alt_ph_no', 'id_card_number', 'email_id',
         'date', 'address', 'city_id', 'status' ];
}