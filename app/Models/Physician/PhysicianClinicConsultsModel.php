<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianClinicConsultsModel extends Model
{
    protected $table = "lmr_phys_clinic_consulting";

    protected $fillable = [
        'user_id', 'clinic_id', 'name', 'speciality', 'email_address', 'mobile_no', 'monthly_visit', 'others', 'description','status'
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
