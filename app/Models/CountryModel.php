<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    protected $table = "lmr_countries";

    public function scopeActiveOnly($query)
    {
        return $query->where('status', '1')->orderBy('name')->get();
    }

    public function states()
    {
        return $this->hasMany(StateModel::class, 'country_id')->select(['id','name'])->where('status','1')->orderBy('name');
    }
}
