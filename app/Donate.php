<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Donate extends Model
{
    use Notifiable;
    public $table = "donations";
    public $timestamps = false;

    protected $fillable = [
        'receipt', 'enter_date','name', 'cust_name','address', 'phone_no', 'alt_phone_no', 'donar_status', 'rupees','currency','sum_of_rupees','amount_type','payment_type','draft_no','draft_date','drawn_on',
        'sponser_child', 'donation_type', 'no_of_children','assign_to', 'from_date', 'to_date', 'status', 'user_id', 'remarks', 'email', 'refer_by', 'update_by', 'update_date', 'creation_date'  ];
}