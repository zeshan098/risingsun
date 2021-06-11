<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Customer_Log extends Model
{
    use Notifiable;
    public $table = "customer_logs";
    public $timestamps = false;

    protected $fillable = ['cust_id', 'name', 'address', 'email','phone_no', 'alt_phone_no', 'status', 'date', 'user_id'];
}
