<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    use Notifiable;
    public $table = "incentives";
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'amount','incentive_percentage', 'date', 'status' ];
}
