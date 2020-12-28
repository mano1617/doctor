<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionQualifyModel extends Model
{
    protected $table = "lmr_mstr_pro_qualify";
    protected $fillable = ['name', 'status'];

    public function scopeActiveOnly($query)
    {
        return $query->where('status','1')->orderBy('name')->get();
    }

    public function scopeBothInActive($query)
    {
        return $query->where('status','!=','2')->orderBy('name')->get();
    }
}
