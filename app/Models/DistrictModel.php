<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistrictModel extends Model
{
    protected $table = "lmr_districts";

    public function scopeActiveOnly($query)
    {
        return $query->orderBy('name')->get();
    }

}
