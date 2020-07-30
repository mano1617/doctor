<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianAdditionalEduModel extends Model
{
    protected $table = "lmr_physician_add_edu";

    protected $fillable = [
        'user_id' ,'professional_qualification', 'branch', 'college', 'join_year', 'place'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function professional()
    {
        return $this->belongsTo(DesignationMasterModel::class,'professional_qualification');
    }

    public function scopeActiveOnly($query)
    {
        return $query->where('status','1')->latest()->get();
    }
}
