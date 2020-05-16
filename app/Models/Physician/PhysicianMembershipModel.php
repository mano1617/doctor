<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianMembershipModel extends Model
{
    protected $table = "lmr_profile_physician_membership";

    protected $fillable = [
        'user_id', 'record_type', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
