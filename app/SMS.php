<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    use Notifiable;
    public $table = "smscreations";
    public $timestamps = false;

    protected $fillable = [
        'payment_type', 'sms_text', 'donation_type', 'date_con', 'status', 'user_id' ];
}
