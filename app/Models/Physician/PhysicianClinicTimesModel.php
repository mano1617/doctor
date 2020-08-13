<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianClinicTimesModel extends Model
{
    protected $table = "lmr_phys_clinic_working_day";

    protected $fillable = [
        'user_id', 'clinic_id', 'clinic_type', 'day_name', 'morning_session_time', 'evening_session_time', 'description', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function clinic()
    {
        return $this->belongsTo(PhysicianClinicModel::class,'clinic_id');
    }
}
