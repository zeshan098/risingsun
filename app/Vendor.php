<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use Notifiable;
    public $table = "vendors";
    public $timestamps = false;

    protected $fillable = [
        'name', 'phone_no', 'alt_phone_no', 'address', 'date', 'status' ];
}
