<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Notifiable;
    public $table = "brands";
    public $timestamps = false;

    protected $fillable = [
        'name', 'status' ];
}
