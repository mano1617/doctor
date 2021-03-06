<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhysicianMembershipMasterModel extends Model
{
    protected $table = "lmr_physician_memberships";

    protected $fillable = [
        'name', 'description'
    ];

    public function scopeActiveOnly($query)
    {
        return $query->where('status','1')->orderBy('name')->get();
    }

    public function scopeBothInActive($query)
    {
        return $query->where('status','!=','2')->orderBy('name')->get();
    }
}
