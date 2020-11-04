<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    protected $table = "lmr_cities";

    public function scopeActiveOnly($query)
    {
        return $query->orderBy('name')->get();
    }

}
