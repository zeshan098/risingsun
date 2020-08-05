<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Vendor_Payment extends Model
{
    use Notifiable;
    public $table = "vendor_payments";
    public $timestamps = false;

    protected $fillable = [
        'vendor_id', 'payment', 'paid_payment', 'remaining_payment', 'payment_type', 'payment_person',
        'bank_slip_no', 'date', 'status','payment_date', 'remarks'];
}
