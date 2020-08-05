<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class Billing extends Model
{
    use Notifiable;
    public $table = "billings";
    public $timestamps = false;

    protected $guarded = ['id'];
    // protected $fillable = [
    //     'bill_number', 'customer_id', 'total_amount', 'total_discount', 'discounted_amount', 'date', 'status',
    // 'payment_type' ];
}
