<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\HospitalModel;
use App\Models\Backend\HospitalConsultantModel;

class HospConsultsWorkModel extends Model
{
    protected $table = "lmr_hospital_consults_wrk_day";

    protected $fillable = [
        'user_id', 'hospital_id', 'consulting_id', 'day_name', 'morning_session_time', 'evening_session_time', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function hospital()
    {
        return $this->belongsTo(HospitalModel::class,'hospital_id');
    }

    public function consultant()
    {
        return $this->belongsTo(HospitalConsultantModel::class,'consulting_id');
    }
}
