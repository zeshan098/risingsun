<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Order_Received extends Model
{
    use Notifiable;
    public $table = "order_receiveds";
    public $timestamps = false;

    protected $fillable = [
        'product_id', 'received_qty', 'vender_id', 'rate', 'csr', 'bill_no', 'date', 'status' ];
}
