<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianClinicConsultsTimesModel extends Model
{
    protected $table = "lmr_phys_clinic_consult_wrk_day";

    protected $fillable = [
        'user_id', 'clinic_id', 'consulting_id', 'day_name', 'morning_session_time', 'evening_session_time', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function clinic()
    {
        return $this->belongsTo(PhysicianClinicModel::class,'clinic_id');
    }

    public function consultant()
    {
        return $this->belongsTo(PhysicianClinicConsultsModel::class,'consulting_id');
    }
}
