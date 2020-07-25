<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianAdditionalEduModel extends Model
{
    protected $table = "lmr_physician_add_edu";

    protected $fillable = [
        'user_id' ,'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function scopeActiveOnly($query)
    {
        return $query->where('status','1')->latest()->get();
    }
}
