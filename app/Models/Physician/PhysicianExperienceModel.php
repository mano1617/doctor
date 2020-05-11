<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianExperienceModel extends Model
{
    protected $table = "lmr_profile_physician_experience";

    protected $fillable = [
        'user_id', 'designation', 'institution', 'place', 'working_years', 'homoeo_experience_years', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
