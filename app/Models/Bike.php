<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{

    protected $table = 'bikes';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    public function appointment()
    {
        return $this->hasMany(OnlineAppointment::class, 'bike_id');
    }
}
