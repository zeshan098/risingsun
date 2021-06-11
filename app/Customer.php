<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Notifiable;
    public $table = "customers";
    public $timestamps = false;

    protected $fillable = ['name', 'address', 'email','phone_no', 'alt_phone_no', 'status', 'date'];
}
