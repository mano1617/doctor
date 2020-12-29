<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class HospitalConsultantModel extends Model
{
    protected $table = "lmr_hospital_consultants";

    protected $fillable = [
        'user_id', 'hospital_id', 'self_register', 'name', 'speciality', 'email_address', 'mobile_no', 'monthly_visit', 'others', 'description','status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function hosiptal()
    {
        return $this->belongsTo(HospitalModel::class,'hospital_id');
    }

    public function workingDays()
    {
        return $this->hasMany(HospConsultsWorkModel::class,'consulting_id')->where('status','1');
    }
}
