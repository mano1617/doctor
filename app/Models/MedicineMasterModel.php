<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineMasterModel extends Model
{
    protected $table = "lmr_mstr_branch_medicine";
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
