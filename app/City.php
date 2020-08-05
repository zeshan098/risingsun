<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use Notifiable;
    public $table = "cities";
    public $timestamps = false;

    protected $fillable = [
        'name', 'status', 'date' ];
}
