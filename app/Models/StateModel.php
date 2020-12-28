<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DistrictModel;

class StateModel extends Model
{
    protected $table = "lmr_states";

    public function scopeActiveOnly($query)
    {
        return $query->where('status','1')->orderBy('name')->get();
    }

    public function consultant()
    {
        return $this->belongsTo(CountryModel::class, 'country_id');
    }

    public function cities()
    {
        return $this->hasMany(DistrictModel::class, 'state_id');
    }
}
